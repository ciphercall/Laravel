<?php

namespace App\Http\Controllers\Frontend;

use App\DeliveredNotifyReceiver;
use App\Delivery;
use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Mail\OrderGenerated;
use App\Models\BillingAddress;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\City;
use App\Models\Coupon;
use App\Models\DeliveryAddress;
use App\Models\Division;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PostCode;
use App\Models\UserCoupon;
use App\PointRedeem;
use App\Temp;
use App\Traits\CalculateCart;
use App\Traits\DistributePoints;
use App\Traits\SMS;
use App\Traits\MakeTransaction;
use App\Traits\UserFallBackServiceTrait;
use App\User;
use ErrorException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    use CalculateCart, SMS, MakeTransaction, UserFallBackServiceTrait, DistributePoints;
    private $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

#region ROUTES
    public function index(Request $request)
    {
        return $this->agent->isMobile() ? view('mobile.pages.new-checkout') : view('frontend.pages.new-checkout');
    }

    public function store(Request $request)
    {
        if ($request->buy_now == 1) {
            $cart = $this->calculateCart(false, session()->get('fake_cart'));
        } else {
            $cart = $this->calculateCart();
        }
        if ($cart->total == 0)
            return redirect()->to('/');

        $output = null;
        if($request->type == "cash"){
            try {
                DB::beginTransaction();
                $billing_address = $this->setupBillingAddress($request);
                $this->updateUserAddress($billing_address);
                $delivery_address = $this->setupDeliveryAddress($request);
                $user_coupon = $this->setupUserCoupon($cart);
                $order = $this->setupOrder($request, $billing_address,$delivery_address, $user_coupon, $cart);
                $output = $this->finalizeOrder($request, $cart, $order, $billing_address, $order->items);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Something Unexpected Occured');
            }
        }else{
            try{
                DB::beginTransaction();
                $billing_address = $this->setupBillingAddress($request);
                $this->updateUserAddress($billing_address);
                $delivery_address = $this->setupDeliveryAddress($request);
                DB::commit();
                $this->finalizeGatewayOrder($cart,$billing_address,$delivery_address);
            }catch(Exception $e){
                DB::rollBack();
                return back()->with('error', 'Something Unexpected Occured');
            }
        }
        return $output;
    }

    public function cashOnDelivery(Request $request)
    {
        $cart = $this->calculateCart();
        if ($cart->total == 0)
            return redirect()->to('/');

        try {
            DB::beginTransaction();
            $billing_address = BillingAddress::whereAuthUser()->latest()->first();
            $user_coupon = $this->setupUserCoupon($cart);
            $order = $this->setupOrder($request, $billing_address, null , $user_coupon, $cart);
            $output = $this->finalizeOrder($request, $cart, $order, $billing_address, $order->items);
            $this->emptyCart();
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Unexpected Occured');
        }
        return redirect()->route('order.details',$order->id)->with('success', 'Thank You for Your Purchase. Order #' . $order->no . ' generated successfully!');

    }

    public function payOnline(Request $request)
    {
        $cart = $this->calculateCart();

        if ($cart->total == 0)
            return redirect()->to('/');

        try{
            DB::beginTransaction();
            $billing_address = BillingAddress::whereAuthUser()->latest()->first();
            DB::commit();
            $this->finalizeGatewayOrder($cart,$billing_address,$billing_address);
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error', 'Something Unexpected Occured');
        }
    }

    public function payPartial(Request $request)
    {
        $cart = $this->calculateCart();

        if ($cart->total == 0)
            return redirect()->to('/');

        try {
            DB::beginTransaction();
            $billing_address = BillingAddress::whereAuthUser()->latest()->first();
            DB::commit();
            $this->finalizeGatewayOrder($cart, $billing_address, $billing_address,true);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Unexpected Occured');
        }
    }

    public function ipn(Request $request)
    {
        // dd($request->all());
        $this->logPayment($request);
    }
    public function success(Request $request)
    {
        $cart = $this->calculateCart();
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        
        $billing_address = BillingAddress::where('user_id', auth('web')->id())->latest()->first();
        $delivery_address = DeliveryAddress::where('user_id',auth('web')->id())->latest()->first();
        $user_coupon = $this->setupUserCoupon($cart);
        $order = $this->gatewayOrder($billing_address,$delivery_address,$user_coupon,$cart,$request->tran_id,$amount);

        // $output = $this->finalizeOrder($request, $cart, $order, $billing_address, $order->items);
        // to create order required params are $cart,$billing_address,$delivery_address,
        $order = Order::with('billing_address')->where('transaction_no', $tran_id)->first();
        $this->emptyCart();
        if ($order->payment_status == 'Unpaid') {
            $validation = (new SslCommerzNotification)->orderValidate($tran_id, $amount, $currency, $request->all());

            if ($validation == TRUE) {
                if ($cart->partial_payment && $cart->partial_payment_amount == $amount) {
                    $order->payment_status = 'Partially Paid';
                }else{
                    $order->payment_status = 'Paid';
                }
                // $order->payment_status = 'Paid';
                $order->save();
                // $this->makeSaleTransaction($order);
                return $this->sendNotification($order->billing_address, $order, 'payment-received',$order->items);
            } else {
                $order->payment_status = 'Failed';
                $order->save();
                return $this->sendNotification($order->billing_address, $order, 'payment-failed',$order->items);
            }
        } else {
            $order->payment_status = 'Failed';
            $order->save();
            return $this->sendNotification($order->billing_address, $order, 'payment-failed',$order->items);
        }
    }

    public function fail(Request $request)
    {
        // $tran_id = $request->input('tran_id');
        // $order = Order::with('billing_address')->where('no', $tran_id)->first();

        // if ($order->payment_status != 'Paid') {
        //     $order->payment_status = 'Failed';
        //     $order->save();
        //     return $this->sendNotification($order->billing_address, $order, 'payment-failed',$order->items);
        // }

        return redirect()->route('frontend.checkout.index')->with('error','Online Payment was Failed. Try again.');
    }

    public function cancel(Request $request)
    {
        // dd($request->all());
        // $tran_id = $request->input('tran_id');
        // $order = Order::with('billing_address')->where('no', $tran_id)->first();

        // if ($order->payment_status != 'Paid') {
        //     $order->payment_status = 'Cancelled';
        //     $order->save();
        //     return $this->sendNotification($order->billing_address, $order, 'payment-failed',$order->items);
        // }

        return redirect()->route('frontend.checkout.index')->with('error','Online Payment was cancelled. Try again.');
    }
#endregion

#region HELPERS
    private function fakeCart(Request $request)
    {
        $cart = new Cart;
        $cart->id = -1;
        $cart->user_id = auth('web')->id();
        $cart->coupon = $request->coupon;

        $cartItem = new CartItem;
        $cartItem->id = -1;
        $cartItem->cart_id = -1;
        $cartItem->item_id = az_unhash($request->item);
        $cartItem->variant_id = az_unhash($request->variant);
        $cartItem->seller_id = az_unhash($request->seller);
        $cartItem->qty = $request->qty;
        $cartItem->active = 1;

        $cart->cart_items = collect([$cartItem]);

        return $cart;
    }

    private function getCommonCheckoutData()
    {
        $data = [];
        $data['divisions'] = Division::orderBy('id')->get(['id', 'name']);
        $data['cities'] = City::where('division_id', auth('web')->user()->division_id)->get(['id', 'name']);
        $data['areas'] = PostCode::where('city_id', auth('web')->user()->city_id)->get(['id', 'name']);

        $shipping_address = DeliveryAddress::whereAuthUser()->latest()->first();
        $data['shipping_divisions'] =  $data['divisions'];
        if($shipping_address != null){
            $data['shipping_cities'] = City::where('division_id', $shipping_address->division_id)->get(['id', 'name']);
            $data['shipping_areas'] = PostCode::where('city_id', $shipping_address->city_id)->get(['id', 'name']);
        }else{
            $data['shipping_cities'] = $data['cities'];
            $data['shipping_areas'] = $data['areas'];
        }

        return $data;
    }

    private function prepareGatewayRequest(Request $request)
    {
        $cart_json = json_decode($request->cart_json, true);
        $request->merge([
            // 'type' => 'gateway',

            'bill_name' => $cart_json['bill_name'],
            'bill_mobile' => $cart_json['bill_mobile'],
            'bill_email' => $cart_json['bill_email'],
            'bill_division' => $cart_json['bill_division'],
            'bill_city' => $cart_json['bill_city'],
            'bill_area' => $cart_json['bill_area'],
            'bill_address_line_1' => $cart_json['bill_address_line_1'],
            'bill_address_line_2' => array_key_exists('bill_address_line_2', $cart_json) ? $cart_json['bill_address_line_2'] : null,

            'ship_name' => array_key_exists('ship_address_line_2', $cart_json) ? $cart_json['ship_name'] : null,
            'ship_mobile' => array_key_exists('ship_address_line_2', $cart_json) ? $cart_json['ship_mobile'] : null,
            'ship_email' => array_key_exists('ship_address_line_2', $cart_json) ? $cart_json['ship_email'] : null,
            'ship_division' => array_key_exists('ship_address_line_2', $cart_json) ? $cart_json['ship_division'] : null,
            'ship_city' => array_key_exists('ship_address_line_2', $cart_json) ? $cart_json['ship_city'] : null,
            'ship_area' => array_key_exists('ship_address_line_2', $cart_json) ? $cart_json['ship_area'] : null,
            'ship_address_line_1' => array_key_exists('ship_address_line_2', $cart_json) ? $cart_json['ship_address_line_1'] : null,
            'ship_address_line_2' => array_key_exists('ship_address_line_2', $cart_json) ? $cart_json['ship_address_line_2'] : null,
        ]);
        return $request;
    }

    private function setupBillingAddress(Request $request)
    {
        return BillingAddress::create([
            'name' => $request->bill_name,
            'user_id' => auth('web')->id(),
            'division_id' => az_unhash($request->bill_division),
            'city_id' => az_unhash($request->bill_city),
            'post_code_id' => az_unhash($request->bill_area),
            'mobile' => $request->bill_mobile,
            'email' => $request->bill_email,
            'address_line_1' => $request->bill_address_line_1,
            'address_line_2' => $request->bill_address_line_2,
        ]);
    }


    private function updateUserAddress($billing_address)
    {
        User::where('id', auth('web')->id())->update([
            'email' => $billing_address->email,
            'division_id' => $billing_address->division_id,
            'city_id' => $billing_address->city_id,
            'post_code_id' => $billing_address->post_code_id,
            'address_line_1' => $billing_address->address_line_1,
            'address_line_2' => $billing_address->address_line_2,
        ]);
    }

    private function setupDeliveryAddress(Request $request)
    {
        // dd($request->all());
        // if (!$request->has_shipping)
        //     return null;
        // if($request->has('is_same_as_Bill_add') && $request->is_same_as_Bill_add == 'on'){
            return DeliveryAddress::updateOrCreate([
                'user_id' => auth('web')->id(),
            ], [
                'name' => $request->bill_name,
                'user_id' => auth('web')->id(),
                'division_id' => az_unhash($request->bill_division),
                'city_id' => az_unhash($request->bill_city),
                'post_code_id' => az_unhash($request->bill_area),
                'mobile' => $request->bill_mobile,
                'email' => $request->bill_email,
                'address_line_1' => $request->bill_address_line_1,
                'address_line_2' => $request->bill_address_line_2,
            ]);
        // }
        // return DeliveryAddress::updateOrCreate([
        //     'user_id' => auth('web')->id(),
        // ], [
        //     'division_id' => az_unhash($request->ship_division),
        //     'city_id' => az_unhash($request->ship_city),
        //     'post_code_id' => az_unhash($request->ship_area),
        //     'name' => $request->ship_name,
        //     'mobile' => $request->ship_mobile,
        //     'email' => $request->ship_email,
        //     'address_line_1' => $request->ship_address_line_1,
        //     'address_line_2' => $request->ship_address_line_2,
        // ]);
    }
    private function gatewayOrder($billing_address, $delivery_address, $user_coupon, $cart,$tran_id,$amount){

        if($delivery_address != null){
            $isDhaka = az_is_dhaka($delivery_address->city_id);
        }else{
            $isDhaka = az_is_dhaka($billing_address->city_id);
        }
        $temp = Temp::where('user_id',auth('web')->id())->first();

        $partialPayment = false;
        $partialPaymentAmount = 0;

        if ($cart->partial_payment && $cart->partial_payment_amount == $amount) {
            $partialPayment = true;
            $partialPaymentAmount = $amount;
        }

        $order = Order::create([
            'user_id' => auth('web')->id(),
            'billing_address_id' => $billing_address->id,
            'delivery_address_id' => $delivery_address->id ?? null,
            'user_coupon_id' => $user_coupon->id ?? null,
            'type' => 'gateway',
            'order_time' => date('Y-m-d h:i:s'),
            'subtotal' => $cart->subtotal_without_coupon,
            'seller_subtotal' => $cart->seller_subtotal ?? 0,
            'seller_total' => $cart->seller_subtotal ?? 0,
            'delivery_breakdown' => str_replace('+',' ',str_replace('=', ':', http_build_query(($cart->deliveryBreakdown ?? []), null, ','))),
            /*
                ! Old System adds Vat
            */
            // 'vat' => $cart->vat,

            /*
                ? New System Doesn't adds vat
            */
            'vat' => 0,
            'shipping_charge' => $cart->delivery_charge,
            'agent_charge' => $isDhaka ? $cart->agent_charge_dhaka : $cart->agent_charge_other,
            'total' => $cart->total,
            'order_status' => 'Pending',
            'payment_status' => 'Unpaid',
            'partial_payment' => $partialPayment,
            'partial_payment_amount' => $partialPaymentAmount,
            'note' => $temp != null ? $temp->note : null,
        ]);
        $order->no = az_hash($order->id,'order');
        $order->transaction_no = $tran_id;
        $order->save();
        
        if($temp != null){
            $temp->delete();
        }
        foreach (collect($cart->cart_items->where('active', true))->groupBy('seller_id') as $key => $group) {

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
                $total += $cItem->sale_percentage > 0 ? $cItem->sale_price : $cItem->original_price;
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
                'seller_total' => $sellerTotal ?? 0,
                'shipping_charge' => $isDhaka
                    ? round($delivery_charge_extra + $maxCustomerDhaka, 2)
                    : round($delivery_charge_extra + $maxCustomerOther, 2),
                'agent_charge' => round($isDhaka ? $maxAgentDhaka : $maxAgentOther, 2),
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
                    'subtotal' => $cItem->sale_percentage > 0 ? $cItem->sale_subtotal : $cItem->subtotal,
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

    public function gatewayPayment()
    {
        # code...
    }
    private function setupUserCoupon($cart)
    {
        if ($cart->coupon == null)
            return null;

        $coupon = Coupon::with('couponExtra:id,coupon_id,type,coupon_on')->where('name',$cart->coupon)->first();
        $extra = $coupon->couponExtra->first();

        if ($coupon == null)
            return null;

        return UserCoupon::create([
            'user_id' => auth('web')->id(),
            'coupon_id' => $coupon->id,
            'name' => $cart->coupon,
            'type' => $extra->type,
            'value' => $cart->coupon_value,
            'coupon_on' => $extra->coupon_on
        ]);
    }

    private function setupOrder(Request $request, $billing_address, $delivery_address, $user_coupon, $cart)
    {
        if($delivery_address != null){
            $isDhaka = az_is_dhaka($delivery_address->city_id);
        }else{
            $isDhaka = az_is_dhaka($billing_address->city_id);
        }
        $point_redeem = null;
        if($cart->redeem_value != null && $cart->redeem_value > 0){
            $point_redeem = PointRedeem::where('code',$cart->redeem)->where('status','active')->first();
            if($point_redeem != null){
                $point_redeem->status = 'Used';
                $point_redeem->update();
            }
        }
        $temp = Temp::where('user_id',auth('web')->id())->first();
        $order = Order::create([
            'user_id' => auth('web')->id(),
            'point_redeem_id' => $point_redeem->id ?? null,
            'billing_address_id' => $billing_address->id,
            'delivery_address_id' => $delivery_address->id ?? null,
            'user_coupon_id' => $user_coupon->id ?? null,
            'type' => "cash",
            'order_time' => date('Y-m-d h:i:s'),
            'subtotal' => $cart->subtotal_without_coupon,
            'seller_subtotal' => $cart->seller_subtotal ?? 0,
            'seller_total' => $cart->seller_subtotal ?? 0,
            'vat' => $cart->vat,
            'shipping_charge' =>$cart->delivery_charge,
            'agent_charge' => $isDhaka ? $cart->agent_charge_dhaka : $cart->agent_charge_other,
            'total' => $cart->total,
            'delivery_breakdown' => str_replace('+',' ',str_replace('=', ':', http_build_query(($cart->deliveryBreakdown ?? []), null, ','))),
            'order_status' => 'Pending',
            'payment_status' => 'Unpaid',
            'note' => $temp != null ? $temp->note : null,
        ]);
        $order->no = "ANC-".az_hash($order->id, 'order');
        $order->save();

        if($temp != null){
            $temp->delete();
        }
        
        foreach (collect($cart->cart_items->where('active', true))->groupBy('seller_id') as $key => $group) {

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
                $total += $cItem->sale_percentage > 0 ? $cItem->sale_price : $cItem->original_price;
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
                'seller_total' => $sellerTotal ?? 0,
                'shipping_charge' => $isDhaka
                    ? round($delivery_charge_extra + $maxCustomerDhaka, 2)
                    : round($delivery_charge_extra + $maxCustomerOther, 2),
                'agent_charge' => round($isDhaka ? $maxAgentDhaka : $maxAgentOther, 2),
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
                    'subtotal' => $cItem->sale_percentage > 0 ? $cItem->sale_subtotal : $cItem->subtotal,
                    'discount' => $cItem->original_subtotal - $cItem->subtotal,
                    'seller_subtotal' => $cItem->seller_subtotal ?? 0,
                    'commission' => $cItem->commission,
                    'vat' => $cItem->vat
                ]);
            }
        }

        return $order;
    }

    private function finalizeOrder(Request $request, $cart, $order, $billing_address, $items)
    {
        $order->histories()->create([
            'type' => 'Created',
            'time' => $order->order_time
        ]);

        /*
            ! For Old Form System
        */

        // if ($request->type == 'cash')
        return $this->finalizeCODOrder($order, $billing_address, $request->buy_now > 0,$items);


        return null;
    }

    public function finalizeCODOrder($order, $billing_address, $is_fake_cart,$items)
    {
        $this->emptyCart($is_fake_cart ? 'fake_cart' : null);
        $this->distributePoint(auth()->user(),$order);
        return $this->sendNotification($billing_address, $order, 'order-created',$items);
    }

    private function sendNotification($billing_address, $order, $event,$items)
    {
        switch ($event) {
            case 'order-created':
                try {
                    $this->sendSMS($billing_address->mobile, "আপনার #" . $order->no . " অর্ডারটি পর্যালোচনার জন্য অপেক্ষায়মান রয়েছে।");
                } catch (\Exception $e) {
                    dd('sms',$e);
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
                    //
                }

                try {
                    Mail::to($billing_address->email)->send(new OrderGenerated($order, $billing_address->name,$items));
                } catch (\Exception $e) {
                    //dd('email',$e);
                }
                return redirect()->route('order.details',$order->id)->with('success', 'Thank You for Your Purchase. Order #' . $order->no . ' generated successfully!');

            case 'payment-received':
                try {
                    $this->sendSMS($billing_address->mobile, "আপনার #" . $order->no . " অর্ডারটির জন্য অনলাইন পেমেন্ট সফল হয়ছে");
                } catch (\Exception $e) {

                }
                try {
                    Mail::to($billing_address->email)->send(new OrderGenerated($order, $billing_address->name,$items));
                } catch (\Exception $e) {
                    //dd('email',$e);
                }

                return redirect()->route('order.details',$order->id)->with('success', 'Thank You for Your Purchase. Payment for Order #' . $order->no . ' is successfull!');

            case 'payment-failed':
                try {
                    $this->sendSMS($billing_address->mobile, "আপনার #" . $order->no . " অর্ডারটির জন্য অনলাইন পেমেন্ট সফল হয়নি");
                } catch (\Exception $e) {
                }

                return redirect()->to('/')->with('error', 'Online payment for #' . $order->no . ' failed!');
        }

        return null;
    }

    public function finalizeGatewayOrder($cart, $billing_address,$delivery_address = null,$is_partial_payment = false)
    {
        if($delivery_address != null){
            $isDhaka = az_is_dhaka($delivery_address->city_id);
        }else{
            $isDhaka = az_is_dhaka($billing_address->city_id);
        }

        $post_data = [];
        $post_data['tran_id'] = Str::uuid();
        $post_data['total_amount'] = $is_partial_payment ? $cart->partial_payment_amount : $cart->total;
        $post_data['currency'] = "BDT";

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $billing_address->name;
        $post_data['cus_email'] = $billing_address->email;
        $post_data['cus_add1'] = $billing_address->address_line_1;
        $post_data['cus_add2'] = $billing_address->address_line_2 ?? ($billing_address->area != null ? $billing_address->area->name : $billing_address->city->name);
        $post_data['cus_city'] = $billing_address->city->name;
        $post_data['cus_state'] = $billing_address->division->name;;
        $post_data['cus_postcode'] = "1000";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '88' . $billing_address->mobile;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = $delivery_address->name;
        $post_data['ship_add1'] = $delivery_address->address_line_1;
        $post_data['ship_add2'] = $delivery_address->address_line_2 ?? $delivery_address->city->name;
        $post_data['ship_city'] = $delivery_address->city->name;
        $post_data['ship_state'] = $delivery_address->division->name;
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = '88' . $delivery_address->mobile;
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "YES";
        $post_data['product_name'] = $this->getItemNames($cart);
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        $ssl = new SslCommerzNotification;
        $ssl->makePayment($post_data, 'hosted', 'json');
    }

    private function getItemNames($cart)
    {
        return implode(', ', collect($cart->cart_items)->map(function ($c) {
            return $c->product->name;
        })->toArray());
    }
    #endregion

    #region MISC AJAX
    public function citiesAjax(Request $request)
    {
        $cities = [];
        if ($request->division) {
            $tmp = City::where('division_id', az_unhash($request->division))
                ->get(['id', 'division_id', 'name']);

            foreach ($tmp as $t) {
                $cities[] = [
                    'id' => az_hash($t->id),
                    'name' => $t->name
                ];
            }
        }
        return response()->json(['cities' => $cities]);
    }

    public function areasAjax(Request $request)
    {
        $areas = [];
        if ($request->city) {
            $tmp = PostCode::where('city_id', az_unhash($request->city))
                ->get(['id', 'city_id', 'name']);

            foreach ($tmp as $t) {
                $areas[] = [
                    'id' => az_hash($t->id),
                    'name' => $t->name
                ];
            }
        }
        return response()->json(['areas' => $areas]);
    }
}
#endregion
