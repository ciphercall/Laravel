<?php

namespace App\Http\Controllers\API;

use App\DeliveredNotifyReceiver;
use App\Http\Controllers\Controller;
use App\Mail\OrderGenerated;
use App\Models\BillingAddress;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\UserCoupon;
use App\PointRedeem;
use App\Traits\CalculateCart;
use App\Traits\DistributePoints;
use App\Traits\SMS;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    use CalculateCart,SMS, DistributePoints;

    private $user,$cart,$address, $is_main_location,$userCoupon;

    function cashOnDelivery(Request $request){
        try {
            DB::beginTransaction();
            $this->initRequiredVars();
            $order = $this->setupOrder($request);
            $this->sendNotification($order,'order-created',$order->items);
            DB::commit();
            $this->emptyCartAPI($this->user);
            return response()->json([
                'status' => 'success',
                'msg' => 'Order is Placed successfully.',
                'data' => $order
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'msg' => 'Error Placing Order. Try again.',
                'data' => [$exception]
            ],400);
        }
    }

    function payOnline(Request $request){
        try {
            DB::beginTransaction();
            $this->initRequiredVars();
            $order = $this->setupOrder($request,"Paid",'gateway');
            // $this->validatePayment($order);
            $this->sendNotification($order,'order-created',$order->items);
            DB::commit();
            $this->emptyCartAPI($this->user);
            return response()->json([
                'status' => 'success',
                'msg' => 'Order is Paid successfully.',
                'data' => $order
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
        }
        return response()->json([
            'status' => 'error',
            'msg' => 'Error Placing Order. Try again.',
            'data' => []
        ],400);

    }

    public function payPartial(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->initRequiredVars();
            $order = $this->setupOrder($request,"Partially Paid",'gateway',true);
            // $this->validatePayment($order);
            $this->sendNotification($order,'order-created',$order->items);
            DB::commit();
            $this->emptyCartAPI($this->user);
            return response()->json([
                'status' => 'success',
                'msg' => 'Order is Partially Paid successfully.',
                'data' => $order
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
        }
        return response()->json([
            'status' => 'error',
            'msg' => 'Error Placing Order. Try again.',
            'data' => []
        ],400);
    }

    private function initRequiredVars(){
        $this->user = $this->getUser();
        $this->cart = $this->calculateCartAPI();
        $this->address = $this->getAddress($this->user);
        $this->is_main_location = az_is_dhaka($this->address->city_id);
        $this->userCoupon = $this->setupUserCoupon($this->cart);
    }

    private function getAddress(User $user){
        return BillingAddress::where('user_id',$user->id)->latest()->first();
    }

    private function setupUserCoupon($cart){
        if ($cart->coupon == null)
            return null;

        $coupon = Coupon::with('couponExtra:id,coupon_id,type,coupon_on')->where('name',$cart->coupon)->first();
        $extra = $coupon->couponExtra->first();

        if ($coupon == null)
            return null;

        return UserCoupon::create([
            'user_id' => $this->user->id,
            'coupon_id' => $coupon->id,
            'name' => $cart->coupon,
            'type' => $extra->type,
            'value' => $cart->coupon_value,
            'coupon_on' => $extra->coupon_on
        ]);
    }

    private function setupOrder(Request $request,$payment = "Unpaid",$paymentType = "cash",$is_partial_payment = false){

        $point_redeem = null;
        if($this->cart->redeem_value != null && $this->cart->redeem_value > 0){
            $point_redeem = PointRedeem::where('code',$this->cart->redeem)->where('status','active')->first();
            if($point_redeem != null){
                $point_redeem->status = 'Used';
                $point_redeem->update();
            }
        }

        $order = Order::create([
            'user_id' => $this->user->id,
            'point_redeem_id' => $point_redeem->id ?? null,
            'billing_address_id' => $this->address->id,
//            'delivery_address_id' => $delivery_address->id ?? null,
            'delivery_address_id' => null,
            'user_coupon_id' => $this->userCoupon->id ?? null,
            'type' => $paymentType,
            'order_time' => date('Y-m-d h:i:s'),
            'subtotal' => $this->cart->subtotal_without_coupon,
            'seller_subtotal' => $this->cart->seller_subtotal ?? 0,
            'seller_total' => $this->cart->seller_subtotal ?? 0,
            'delivery_breakdown' => str_replace('+',' ',str_replace('=', ':', http_build_query(($this->cart->deliveryBreakdown ?? []), null, ','))),
            /*
                ! Old System adds Vat
            */
            // 'vat' => $cart->vat,

            /*
                ? New System Doesn't adds vat
            */
            'vat' => 0,
            'shipping_charge' => $this->cart->delivery_charge,
            'agent_charge' => $this->is_main_location ? $this->cart->agent_charge_dhaka : $this->cart->agent_charge_other,
            'total' => $this->cart->total,
            'partial_payment' => $is_partial_payment,
            'partial_payment_amount' => $is_partial_payment ? $this->cart->partial_payment_amount : 0,
            'order_status' => 'Pending',
            'payment_status' => $payment,
            'note' => $request->note,
            'platform_origin' => 'App',
        ]);
        $order->transaction_no = $request->tran_id;
        $order->no = az_hash($order->id,'order');
        $order->save();

        foreach (collect($this->cart->cart_items->where('active', true))->groupBy('seller_id') as $key => $group) {

            $total = 0;
            $sellerTotal = 0;
            $commission = 0;
            $vat = 0;
            $maxCustomerDhaka = 0;
            $maxCustomerOther = 0;
            $maxAgentDhaka = 0;
            $maxAgentOther = 0;
            $delivery_charge_extra = 0;
            foreach ($group as $cItem) {
                $total += $cItem->subtotal;
                $sellerTotal += $cItem->seller_subtotal ?? 0;
                $commission += $cItem->commission;
                $vat += $cItem->vat;

                if ($cItem->product->delivery_size->customer_dhaka > $maxCustomerDhaka)
                    $maxCustomerDhaka = $cItem->product->delivery_size->customer_dhaka;
                if ($cItem->product->delivery_size->customer_other > $maxCustomerOther)
                    $maxCustomerOther = $cItem->product->delivery_size->customer_other;

                if ($cItem->product->delivery_size->agent_dhaka > $maxAgentDhaka)
                    $maxAgentDhaka = $cItem->product->delivery_size->agent_dhaka;
                if ($cItem->product->delivery_size->agent_other > $maxAgentOther)
                    $maxAgentOther = $cItem->product->delivery_size->agent_other;

                $delivery_charge_extra += $cItem->product->additional_delivery_charge;
            }

            $detail = OrderDetail::create([
                'order_id' => $order->id,
                'seller_id' => $key,
                'total' => $total,
                'commission' => round($commission, 2),
                'vat' => round($vat, 2),
                'seller_total' => $sellerTotal,
                'shipping_charge' => $this->is_main_location
                    ? round($delivery_charge_extra + $maxCustomerDhaka, 2)
                    : round($delivery_charge_extra + $maxCustomerOther, 2),
                'agent_charge' => round($this->is_main_location ? $maxAgentDhaka : $maxAgentOther, 2),
            ]);

            foreach ($group as $cItem) {
                $detail->items()->create([
                    'order_id' => $order->id,
                    'seller_id' => $key,
                    'item_id' => $cItem->item_id,
                    'variant_id' => $cItem->variant_id,
                    'price' => $cItem->sale_percentage > 0 ? $cItem->sale_price : $cItem->original_price,
                    'seller_price' => $cItem->seller_price ?? 0,
                    'qty' => $cItem->qty,
                    'subtotal' => $cItem->subtotal,
                    'discount' => $cItem->original_subtotal - $cItem->subtotal,
                    'seller_subtotal' => $cItem->seller_subtotal ?? 0,
                    'commission' => $cItem->commission,
                    'vat' => $cItem->vat
                ]);
            }
        }
        $order->histories()->create([
            'type' => 'Created',
            'time' => $order->order_time
        ]);

        return $order;
    }

    private function sendNotification($order, $event,$items)
    {
        $billing_address = $order->billing_address;
        $this->distributePoint($this->getUser(),$order);
        switch ($event) {
            case 'order-created':
                try {
                    $this->sendSMS($billing_address->mobile, "আপনার #" . $order->no . " অর্ডারটি পর্যালোচনার জন্য অপেক্ষায়মান রয়েছে।");
                } catch (\Exception $e) {
                    Log::channel('system-info-log')->info($e->getMessage());
                }

                // notify stake holders
                try{
                    $notifyReceivers = DeliveredNotifyReceiver::where('status',true)->get();
                    $categories = $order->items->pluck('product.category.name');
                    $sizes = $order->items->pluck('product.unit.name');
                    $sms = "#".$order->no."\nDate:".$order->created_at->format('d.m.y')."\nItems:".implode(',',$categories->all())."\nQty:".implode(',',$sizes->all())."\nTotal:".$order->total;
                    if ($notifyReceivers != null){
                        foreach ($notifyReceivers as $receiver){
                            $this->sendSMSNonMask($receiver->mobile,$sms);
                        }
                    }
                }catch(Exception $e){
                    Log::channel('system-info-log')->info($e->getMessage());
                }

                try {
                    Mail::to($billing_address->email)->send(new OrderGenerated($order, $billing_address->name,$items));
                } catch (\Exception $e) {
                    Log::channel('system-info-log')->info($e->getMessage());
                }
                return response()->json("success");

            case 'payment-received':
                try {
                    $this->sendSMS($billing_address->mobile, "আপনার #" . $order->no . " অর্ডারটির জন্য অনলাইন পেমেন্ট সফল হয়ছে");
                } catch (\Exception $e) {
                    Log::channel('system-info-log')->info($e->getMessage());
                }
                try {
                    Mail::to($billing_address->email)->send(new OrderGenerated($order, $billing_address->name,$items));
                } catch (\Exception $e) {
                    Log::channel('system-info-log')->info($e->getMessage());
                }

                return response()->json("success");

            case 'payment-failed':
                try {
                    $this->sendSMS($billing_address->mobile, "আপনার #" . $order->no . " অর্ডারটির জন্য অনলাইন পেমেন্ট সফল হয়নি");
                } catch (\Exception $e) {
                }

                return response()->json("success");
        }

        return null;
    }
    private function getUser() : User {
        return request()->user();
    }
}
