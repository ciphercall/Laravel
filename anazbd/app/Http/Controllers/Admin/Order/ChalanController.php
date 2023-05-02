<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
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

class ChalanController extends Controller
{
    use SMS;

    function index(){
        $invoices = Chalan::latest()->paginate(15);
        return view('admin.orders.chalan.index',compact('invoices'));
    }
    function edit(Chalan $chalan){
        $chalan->load(['order','chalan_items','chalan_items.item']);
        $order = $chalan->order;
        $order->load(['billing_address','user_coupon']);
        $agents = (new \App\Http\Controllers\Backend\ChalanController())->getSortedAgents($order->billing_address);
        return view('admin.orders.chalan.edit',compact('chalan','order','agents'));
    }
    function create(Order $order){
        $order->load('items','items.product','billing_address');
        $agents = [];
        $orders = null;
        if ($order->id != null){
            $agents = (new \App\Http\Controllers\Backend\ChalanController())->getSortedAgents($order->billing_address);
        }else{
            $orders = Order::whereIn('status',['On Delivery','Delivered','Packing'])->has('chalan_items')->get(['no','id']);
        }
        return view('admin.orders.chalan.create',compact(['order','orders','agents']));
    }

    function store(Request $request){
        $this->validate($request,[
            'chalan_no' => 'required|unique:chalans,chalan_no',
            'order_no' => 'required|string',
            'delivery_charge' => 'required|numeric',
            'order_item.*' => 'required|numeric',
            'qty.*' => 'required|numeric',
            'price.*' => 'required|numeric',
            'subtotal.*' => 'required|numeric',
            'agent' => 'required|numeric'
        ],[
            'agent.numeric' => 'Select Agent for delivery.'
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
            $chalan->total = $subtotal + intval($request->delivery_charge ?? 0);
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
                'status' => 'On Delivery'
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

    function update(Request $request, Chalan $chalan){
        $this->validate($request,[
            'shipping_charge' => 'required|numeric',
            'qty.*' => 'required|numeric',
            'price.*' => 'required|numeric',
            'subtotal.*' => 'required|numeric',
            'agent' => 'required|numeric',
            'subtotal_chalan' => 'required|numeric'
        ],[
            'agent.numeric' => 'Select Agent for delivery.'
        ]);
        $chalan->update([
            'shipping_charge' => $request->shipping_charge == null ? 0 : $request->shipping_charge,
            'subtotal' => $request->subtotal_chalan,
            'total' => $request->subtotal_chalan + intval($request->shipping_charge == null ? 0 : $request->shipping_charge),
            'agent_id' => $request->agent
        ]);

        return redirect()->route('backend.chalan.view',$chalan->chalan_no)->withSuccess("Chalan Updated");
    }

    private function sendnotification($mobile, $message)
    {
        try {
            $this->sendSMS($mobile, $message);
        } catch (\Exception $e) {
            dd('sms',$e);
        }
    }
    private function suggestOrderToAgent($agent_id, $order_id,$chalan_id)
    {
        AgentSuggestOrder::create([
            'agent_id' => $agent_id,
            'order_id' => $order_id,
            'chalan_id' => $chalan_id
        ]);
    }
}
