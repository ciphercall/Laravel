<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\OrderCancelled;
use App\Models\Agent;
use App\Models\AgentSuggestOrder;
use App\Models\Chalan;
use App\Models\ChalanItem;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderItem;
use App\Traits\SMS;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ChalanController extends Controller
{
    use SMS;
    public function index()
    {
        $chalans = Chalan::with('chalan_items')->orderBy('id','desc')->paginate(20);
        return view('backend.chalan.index',compact(['chalans']));
    }

    public function create()
    {
        $orders = Order::whereIn('order_status',['accepted','On Delivery','Delivered'])->has('chalan_items')->get(['no','id']);
        // dd($orders);
        return view('backend.chalan.create',compact('orders'));
    }

    public function getOrderItems($order_no)
    {
        $order = Order::with('user_coupon:id,value,coupon_id','user_coupon.coupon','user_coupon.coupon.couponExtra')->where('no',$order_no)->first();
        $isCouponOnDelivery = false;
        if ($order->user_coupon != null && $order->user_coupon->coupon != null){
            foreach ($order->user_coupon->coupon->couponExtra as $extra){
                if ($extra->coupon_on == "delivery_charge"){
                    $isCouponOnDelivery = true;
                }
            }
        }
        $items = OrderItem::withProductName()->where('order_id',$order->id)->where('chalan',false)->where('active',true)->get();
        $agents = $this->getSortedAgents($order->billing_address);
        return response()->json([
            'items' => $items,
            'delivery_address' => $order->delivery_address != null ? $order->delivery_address->complete_address : 'N/A',
            'billing_address' => $order->billing_address != null ? $order->billing_address->complete_address : 'N/A',
            'order' => $order,
            'agents' => $agents,
            'isCouponOnDelivery' => $isCouponOnDelivery
        ]);
    }

    public function view(String $chalan_no)
    {
        $chalan = Chalan::with('chalan_items','order')->where('chalan_no',$chalan_no)->first();
        return view('backend.chalan.view',compact('chalan'));
    }

    public function renew($no,$to)
    {
        $chalan = Chalan::where('chalan_no',$no)->first()->update([
            'status' => 'Pending'
        ]);

        return redirect()->to($this->statusGetRoute($to));
    }

    public function cancel($no,$to)
    {
        $chalan = Chalan::where('chalan_no',$no)->first();
        $chalan->update([
            'status' => 'Cancelled'
        ]);
        $order = Order::where('id', $chalan->order_id)->with('billing_address')->first();
        $cancelled = $order->chalans->reject(function ($chalan){
            return $chalan->status != 'Cancelled';
        });

        if($order->chalans->count() === $cancelled->count()){
            $order->update(['order_status' => 'Cancelled']);

            OrderHistory::updateOrCreate([
                'order_id' => $order->id,
                'type' => 'Cancelled',
            ], [
                'time' => date('Y-m-d H:i:s')
            ]);

            try {
                $this->sendSMS($order->billing_address->mobile, "আপনার #" . $order->no . " অর্ডারটি বাতিল করা হয়েছে");
            } catch (\Exception $e) {
            }

            try {
                Mail::to($order->billing_address->email)->send(new OrderCancelled($order->no, $order->billing_address->name));
            } catch (\Exception $e) {
            }
        }
        return redirect()->to($this->statusGetRoute($to));
    }

    public function notDelivered($no,$to)
    {
        $chalan = Chalan::where('chalan_no',$no)->first();
        $chalan->update([
            'status' => 'Not Delivered'
        ]);
        return redirect()->to($this->statusGetRoute($to));
    }

    public function store(Request $request)
    {
//         dd($request->all());
        $this->validate($request,[
            'chalan_no' => 'required|unique:chalans,chalan_no',
            'order_no' => 'required|string',
            'delivery_charge' => 'required|numeric',
            'order_item.*' => 'required|numeric',
            'qty.*' => 'required|numeric',
            'price.*' => 'required|numeric',
            'subtotal.*' => 'required|numeric',
            'agent' => 'required|numeric'
        ]);
        $order = Order::where('no',$request->order_no)->with('user_coupon:id,value')->first();
        $discount = $order->user_coupon != null ? $order->user_coupon->value : 0;
        try{
            DB::beginTransaction();
            $subtotal = collect($request->subtotal)->sum();
            $chalan = new Chalan();
            $chalan->order_id = $order->id;
            $chalan->order_no = $order->no;
            $chalan->chalan_no = $request->chalan_no;
            $chalan->shipping_charge = $request->delivery_charge;
            $chalan->subtotal = $subtotal;
            $chalan->agent_id = $request->agent;
            $chalan->total = $subtotal + $request->delivery_charge - $discount;
            $chalan->save();
            foreach($request->order_item as $item){
                $order_item = OrderItem::find($item);
                $order_item->update([
                    'chalan' => true
                ]);
                $chalanItem = new ChalanItem();
                $chalanItem->chalan_id = $chalan->id;
                $chalanItem->item_id = $order_item->product->id;
                $chalanItem->variant_id = $order_item->variant_id;
                $chalanItem->price = $request->price[$item];
                $chalanItem->qty = $request->qty[$item];
                $chalanItem->subtotal = $request->subtotal[$item];
                $chalanItem->save();
            }

            $order->update([
                'order_status' => 'On Delivery'
            ]);

            OrderHistory::updateOrCreate([
                'order_id' => $order->id,
                'type' => 'On Delivery',
            ], [
                'time' => date('Y-m-d H:i:s')
            ]);
            $this->suggestOrderToAgent($request->agent, $order->id,$chalan->id);

            if($order->user->mobile){
                $message = "আপনার #" . $order->no . " অর্ডারটি ডেলিভারীর জন্য পাঠানো হয়েছে।";
                $this->sendnotification($order->billing_address->mobile,$message);
            }
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return redirect()->back()->with(['error'=>'Failed, try again.']);
        }
        return redirect()->route('admin.orders.chalan.index')->with('success','Order awaiting delivery.');
    }

    public function update(Request $request,$id)
    {
        $chalan = Chalan::find($id);
        $chalan->update([
            'agent_id' => $request->agent,
            'status' => 'Pending'
        ]);

        return redirect()->route('backend.order.not-delivered.index')->with('success','Chalan status updated.');
    }
    public function getSortedAgents($billing_address)
    {
        return Agent::with('AgentAllocatedArea', 'AgentExtendArea')
            ->get(['id','name'])
            ->sortBy(function ($agent) use ($billing_address) {
                $allocated = collect($agent->AgentAllocatedArea);
                $extended = collect($agent->AgentExtendArea);
                $agent->order = 0;

                if ($allocated->where('post_id', $billing_address->post_code_id)->count() > 0)
                    $agent->order = -6;
                else if ($extended->where('post_id', $billing_address->post_code_id)->count() > 0)
                    $agent->order = -5;

                else if ($allocated->where('city_id', $billing_address->city_id)->count() > 0)
                    $agent->order = -4;
                else if ($extended->where('city_id', $billing_address->city_id)->count() > 0)
                    $agent->order = -3;

                else if ($allocated->where('division_id', $billing_address->division_id)->count() > 0)
                    $agent->order = -2;
                else if ($extended->where('division_id', $billing_address->division_id)->count() > 0)
                    $agent->order = -1;

                return $agent->order;
            });
    }

    private function suggestOrderToAgent($agent_id, $order_id,$chalan_id)
    {
        AgentSuggestOrder::create([
            'agent_id' => $agent_id,
            'order_id' => $order_id,
            'chalan_id' => $chalan_id
        ]);
    }

    private function sendnotification($mobile, $message)
    {
        try {
            $this->sendSMS($mobile, $message);
        } catch (\Exception $e) {
            dd('sms',$e);
        }
    }
    private function statusGetRoute($to)
    {
        switch ($to) {
            case 'Chalan':
                return route('backend.chalan.index');
            case 'Accept':
                return route('backend.order.waiting.index');
            case 'On Delivery':
                return route('backend.order.on-delivery.index');
            case 'Delivered':
                return route('backend.order.delivered.index');
            case 'Cancelled':
                return route('backend.order.cancelled.index');
            default:
                return route('backend.order.pending.index');
        }
    }
}
