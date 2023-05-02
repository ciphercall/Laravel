<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\OrderCancelled;
use App\Models\Agent;
use App\Models\AgentSuggestOrder;
use App\Models\BillingAddress;
use App\Models\Chalan;
use App\Models\City;
use App\Models\Division;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderHistory;
use App\Models\OrderItem;
use App\Models\PostCode;
use App\Seller;
use App\Traits\CalculateOrder;
use App\Traits\MakeTransaction;
use App\Traits\SMS;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    use CalculateOrder, SMS, MakeTransaction;

/* Notificaion Helper */
private function sendnotification($mobile, $message)
    {
        try {
            $this->sendSMS($mobile, $message);
        } catch (\Exception $e) {
            dd('sms',$e);
        }

    }
/* Notificaion Helper */

#region PENDING
    public function pending(Request $request)
    {
        $data = $this->getCommonFilterData($request, ['cash', 'gateway'], ['Pending']);
        $data['orders'] = $this->getFilteredOrders($request, ['cash', 'gateway'], ['Pending']);

        return view('backend.orders.pending-index', $data);
    }

    public function showPending($id)
    {
        $order = $this->getOrders($id);

        return view('backend.orders.pending-show', compact('order'));
    }

    public function editPending($id)
    {
        $order = $this->getOrder($id);
        $sellers = Seller::get(['id', 'shop_name']);
        $divisions = Division::get(['id', 'name']);

        return view('backend.orders.pending-edit', compact('order', 'sellers', 'divisions'));
    }

    public function updatePending(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'division' => 'required',
            'city' => 'required',
            'area' => 'nullable',
            'address_l1' => 'required',
            'address_l2' => 'nullable',
            'note' => 'nullable',
            'sellers.*' => 'required',
            'items.*' => 'required',
            'variants.*' => 'required',
            'qty.*' => 'required',
            'prices.*' => 'required',
        ]);
        // dd($request->all());
        $request->merge([
            'sellers' => array_unique($request->sellers)
        ]);

        OrderDetail::where('order_id', $id)->whereNotIn('seller_id', $request->sellers)->delete();
        $all_items = [];
        foreach ($request->sellers as $seller) {
            $items = $request->items[$seller];
            $all_items = array_merge($all_items, $items);
            
            $detail = OrderDetail::updateOrCreate([
                'order_id' => $id,
                'seller_id' => $seller,
            ]
            // ,[
            //     'seller_total' => $seller_total
            // ]
        );

            foreach ($items as $item) {
                foreach ($request->variants[$item] as $variant) {
                    // $seller_total = (intval($request->seller_price[$variant]) * intval($request->qty[$variant]));
                    OrderItem::updateOrCreate([
                        'order_id' => $id,
                        'seller_id' => $seller,
                        'detail_id' => $detail->id,
                        'item_id' => $item,
                        'variant_id' => $variant
                    ], [
                        'price' => $request->prices[$variant],
                        'qty' => $request->qty[$variant],
                        'active' => $request->qty[$variant] > 0,
                    ]);
                }
            }
        }

        OrderItem::where('order_id', $id)->whereNotIn('item_id', $all_items)->delete();

        $order = Order::find($id);
        
        $order->update([
            'note' => $request->note,
            'order_status' => 'Accepted'
        ]);

        OrderHistory::updateOrCreate([
            'order_id' => $order->id,
            'type' => 'Accepted',
        ], [
            'time' => date('Y-m-d H:i:s')
        ]);

        $this->updateBillingAddress($request, $order->billing_address_id);
        $this->calculateOrder($id);

        if($order->user->mobile){
            $message = "আপনার #" . $order->no . " অর্ডারটি নেত্তয়া করা হয়েছে।";
            $this->sendnotification($order->billing_address->mobile,$message);
        }
        
        return back()->with('message', 'Order Updated Successfully!');
    }
#endregion


#region WAITING
    public function waiting(Request $request)
    {
        $data = $this->getCommonFilterData($request, null, ['Accepted']);
        $data['orders'] = $this->getFilteredOrders($request, null, ['Accepted']);

        return view('backend.orders.waiting-index', $data);
    }

    public function showWaiting($id)
    {
        $order = $this->getOrders($id);
        $agents = $this->getSortedAgents($order->billing_address);

        return view('backend.orders.waiting-show', compact('order', 'agents'));
    }

    public function editWaiting(Request $request, $id)
    {
        $order = $this->getOrder($id);
        $sellers = Seller::get(['id', 'shop_name']);
        $divisions = Division::get(['id', 'name']);
        $agents = $this->getSortedAgents($order->billing_address);

        return view('backend.orders.waiting-edit', compact('order', 'sellers', 'divisions', 'agents'));
    }

    public function updateWaiting(Request $request, $id)
    {
        // dd($request->all(),'update waiting');
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'division' => 'required',
            'city' => 'required',
            'area' => 'nullable',
            'address_l1' => 'required',
            'address_l2' => 'nullable',
            'note' => 'nullable',
            'qty.*' => 'required',
            'prices.*' => 'required',
            'actives.*' => 'required'
        ]);

        try{
            DB::beginTransaction();
            foreach ($request->qty as $variant => $qty) {
                OrderItem::where('order_id', $id)
                    ->where('variant_id', $variant)
                    ->update([
                        'price' => $request->prices[$variant],
                        'active' => $qty > 0
                            && array_key_exists($variant, $request->actives ?? [])
                            && $request->actives[$variant] == 'on',
                        'qty' => $qty
                    ]);
            }
            $order = Order::find($id);
            $order->update([
                'note' => $request->note
            ]);
            
            $this->updateBillingAddress($request, $order->billing_address_id);
            $this->calculateOrderSplitPartials($id);
            DB::commit();
        }catch (Exception $e){{
            DB::rollBack();
            dd($e);
        }}
        
        return redirect()->route('backend.chalan.index')->with('message', 'Order Updated Successfully! Generate Chalan for delivery.');
        /* Original Order Update Code

        foreach ($request->qty as $variant => $qty) {
            OrderItem::where('order_id', $id)
                ->where('variant_id', $variant)
                ->update([
                    'price' => $request->prices[$variant],
                    'active' => $qty > 0
                        && array_key_exists($variant, $request->actives ?? [])
                        && $request->actives[$variant] == 'on',
                    'qty' => $qty
                ]);
        }

        $order = Order::find($id);
        $order->update([
            'delivery_agent_id' => $request->agent,
            'note' => $request->note,
            'order_status' => 'On Delivery'
        ]);

        OrderHistory::updateOrCreate([
            'order_id' => $order->id,
            'type' => 'On Delivery',
        ], [
            'time' => date('Y-m-d H:i:s')
        ]);

        $this->updateBillingAddress($request, $order->billing_address_id);
        $this->suggestOrderToAgent($request->agent, $order->id);
        $this->calculateOrderSplitPartials($id);
        
        if($order->user->mobile){
            $message = "আপনার #" . $order->no . " অর্ডারটি ডেলিভারীর জন্য পাঠানো হয়েছে।";
            $this->sendnotification($order->billing_address->mobile,$message);
        }

        return back()->with('message', 'Order Updated Successfully!');

        Original order update code end */
    }
#endregion


#region ON DELIVERY
    public function onDelivery(Request $request)
    {
        $data = $this->getCommonFilterData($request, null, ['On Delivery']);
        $data['orders'] = $this->getFilteredOrders($request, null, ['On Delivery']);
        $data['chalans'] = Chalan::where('status','Pending')->with('order','order.user','order.delivery_agent')->paginate(12);
        // dd(Chalan::with('order','order.user','order.delivery_agent')->get());
        $data['title'] = 'On Delivery';

        return view('backend.orders.on-delivery-index', $data);
    }

    public function showOnDelivery($id)
    {
        $chalan = Chalan::find($id);
        $order = $this->getOrders($chalan->order_id);
        return view('backend.orders.on-delivery-show', compact('order','chalan'));
    }
#endregion


#region NOT DELIVERED
    public function notDelivered(Request $request)
    {
        $data = $this->getCommonFilterData($request, null, ['Not Delivered']);
        $data['orders'] = $this->getFilteredOrders($request, null, ['Not Delivered']);
        $data['chalans'] = Chalan::where('status','Not Delivered')->orderByDesc('id')->paginate(20);

        return view('backend.orders.not-delivered-index', $data);
    }

    public function showNotDelivered($id)
    {
        $chalan = Chalan::find($id);
        $order = $this->getOrders($chalan->order_id);
        $agents = $this->getSortedAgents($order->billing_address);

        return view('backend.orders.not-delivered-show', compact('order', 'agents','chalan'));
    }

    public function editNotDelivered(Request $request, $id)
    {
        $chalan = Chalan::find($id);
        $order = $this->getOrder($chalan->order_id);
        $sellers = Seller::get(['id', 'shop_name']);
        $divisions = Division::get(['id', 'name']);
        $agents = $this->getSortedAgents($order->billing_address);

        return view('backend.orders.not-delivered-edit', compact('chalan','order', 'sellers', 'divisions', 'agents'));
    }

    public function updateNotDelivered(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'division' => 'required',
            'city' => 'required',
            'area' => 'nullable',
            'address_l1' => 'required',
            'address_l2' => 'nullable',
            'note' => 'nullable',
            'qty.*' => 'required',
            'prices.*' => 'required',
            'actives.*' => 'required',
            'agent' => 'required'
        ]);

        foreach ($request->qty as $variant => $qty) {
            OrderItem::where('order_id', $id)
                ->where('variant_id', $variant)
                ->update([
                    'price' => $request->prices[$variant],
                    'active' => $qty > 0
                        && array_key_exists($variant, $request->actives ?? [])
                        && $request->actives[$variant] == 'on',
                    'qty' => $qty
                ]);
        }

        $order = Order::find($id);
        $order->update([
            'delivery_agent_id' => $request->agent,
            'note' => $request->note,
            'order_status' => 'On Delivery'
        ]);

        $history = OrderHistory::where('order_id', $order->id)->where('type', 'On Delivery')->first();

        if (!$history) {
            OrderHistory::create([
                'order_id' => $order->id,
                'type' => 'On Delivery',
                'time' => date('Y-m-d H:i:s')
            ]);
        }

        $this->updateBillingAddress($request, $order->billing_address_id);
        $this->suggestOrderToAgent($request->agentd, $order->id);
        $this->calculateOrderSplitPartials($id);

        return back()->with('message', 'Order Updated Successfully!');

        
    }
#endregion


#region DELIVERED
    public function delivered(Request $request)
    {
        $data = $this->getCommonFilterData($request, null, ['Delivered']);
        $data['orders'] = $this->getFilteredOrders($request, null, ['Delivered']);
        $data['chalans'] = Chalan::where('status','Delivered')->with('order','order.user','order.delivery_agent')->paginate(12);
        // dd($data['chalans']);
        return view('backend.orders.delivered-index', $data);
    }


    public function showDelivered($id)
    {
        
        $chalan = Chalan::find($id);
        $order = $this->getOrders($chalan->order_id);
        return view('backend.orders.delivered-show', compact('order','chalan'));
    }
#endregion


#region CANCELLED
    public function cancelled(Request $request)
    {
        $data = $this->getCommonFilterData($request, null, ['Cancelled']);
        $data['orders'] = $this->getFilteredOrders($request, null, ['Cancelled']);
        $data['chalans'] = Chalan::with('order','order.user')->where('status','Cancelled')->orderByDesc('id')->paginate(20);
        return view('backend.orders.cancelled-index', $data);
    }

    public function showCancelled($id)
    {
        $chalan = Chalan::with('order','order.user','chalan_items')->find($id);
        $order = $this->getOrders($chalan->order_id);
        return view('backend.orders.cancelled-show', compact('order','chalan'));
    }
#endregion


#region STATUSES
    public function makePending($id, $to)
    {
        Order::where('id', $id)->update(['order_status' => 'Pending']);

        return redirect()->to($this->statusGetRoute($to));
    }

    public function makeAccepted($id, $to)
    {
        $order = Order::find($id);
        $order->update(['order_status' => 'Accepted']);

        OrderHistory::updateOrCreate([
            'order_id' => $id,
            'type' => 'Accepted',
        ], [
            'time' => date('Y-m-d H:i:s')
        ]);

        $this->findAgentsAndSuggestOrder($id);

        try {
            $this->sendSMS($order->billing_address->mobile, "আপনার #" . $order->no . " অর্ডারটি নেত্তয়া করা হয়েছে");
        } catch (\Exception $e) {
        }

        // try {
        //     Mail::to($order->billing_address->email)->send(new Order($order->no, $order->billing_address->name));
        // } catch (\Exception $e) {
        // }
        return redirect()->to($this->statusGetRoute($to));
    }

    public function makeOnDelivery(Request $request, $id, $to)
    {
        dd(Order::find($id),Chalan::find($id));
        Order::where('id', $id)->update([
            'order_status' => 'On Delivery',
            'delivery_agent_id' => $request->agent,
        ]);

        OrderHistory::updateOrCreate([
            'order_id' => $id,
            'type' => 'On Delivery',
        ], [
            'time' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to($this->statusGetRoute($to));
    }

    public function makeDelivered($id, $to)
    {
        $chalan = Chalan::find($id);
        $chalan->update([
            'status' => 'Delivered'
        ]);
        
        $order = Order::find($chalan->order_id);
        $items = $order->items;
        $chalanGeneratedItems = $chalan->chalan_items->pluck('item_id')->toArray();
        $orderItemsId = $items->pluck('item_id')->toArray();
        $itemsShippedCounter = 0;
        foreach($orderItemsId as $needle){
            if(in_array($needle,$chalanGeneratedItems)){
                $itemsShippedCounter++;
            }
        }
        
        if($itemsShippedCounter == count($orderItemsId)){
            $order->update([
                'order_status' => 'Delivered',
                'payment_status' => 'Paid',
                'delivery_date' => date('Y-m-d H:i:s')
            ]);
    
            OrderHistory::updateOrCreate([
                'order_id' => $order->id,
                'type' => 'Delivered',
            ], [
                'time' => date('Y-m-d H:i:s')
            ]);
    
            $this->makeSaleTransaction(Order::with('details')->find($chalan->order_id));
        }
        

        if($order->user->mobile){
            $message = "আপনার #" . $order->no . " অর্ডারটি সফলভাবে ডেলিভারী করা হয়েছে।";
            $this->sendnotification($order->billing_address->mobile,$message);
        }
        return redirect()->to($this->statusGetRoute($to));
    }

    public function makeCancelled($id, $to)
    {
        $order = Order::where('id', $id)->with('billing_address')->first();
        $order->update(['order_status' => 'Cancelled']);

        OrderHistory::updateOrCreate([
            'order_id' => $id,
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

        return redirect()->to($this->statusGetRoute($to));
    }
#endregion


#region DESTROY
    public function pendingDestroy($id)
    {
        try {
            $order = Order::find($id);
            if ($order->payment_status != 'Paid') {
                BillingAddress::where('id', $order->billing_address_id)->first();
                // AgentSuggestOrder::where('order_id', $order->id)->delete();

                $order->delete();
                return back()->with('message', 'Order deleted successfully!');
            }
        } catch (\Exception $e) {
            dd($e);
        }

        return back()->with('message', 'Sorry order could not be deleted');
    }

    public function destroy($id)
    {
        try {
            $order = Order::find($id);
            if ($order->payment_status != 'Paid') {
                BillingAddress::where('id', $order->billing_address_id)->first();
                AgentSuggestOrder::where('order_id', $order->id)->delete();

                $order->delete();
                return back()->with('message', 'Order deleted successfully!');
            }
        } catch (\Exception $e) {
            dd($e);
        }

        return back()->with('message', 'Sorry order could not be deleted');
    }


#endregion


#region AJAX
    public function ajaxCities($division_id)
    {
        $cities = City::where('division_id', $division_id)->get(['id', 'name', 'division_id']);

        return response()->json(['cities' => $cities]);
    }

    public function ajaxAreas($city_id)
    {
        $areas = PostCode::where('city_id', $city_id)->get(['id', 'name', 'city_id']);

        return response()->json(['areas' => $areas]);
    }

    public function ajaxProducts($seller_id)
    {
        $items = Item::with(['sub_category' => function ($q) {
            $q->select('id', 'vat');
        }])
            ->where('seller_id', $seller_id)
            ->select('id', 'name', 'sub_category_id')
            ->get();

        $products = collect([]);
        foreach ($items as $item) {
            $products->push([
                'id' => $item->id,
                'name' => $item->name,
                'vat' => $item->sub_category->vat
            ]);
        }

        return response()->json(['products' => $products]);
    }

    public function ajaxVariants($product_id, $order_id)
    {
        $time = Order::find($order_id)->order_time;

        $item = Item::where('id', $product_id)
            ->with('variants')
            ->with('flash_sales')
            ->select('id', 'name')
            ->first();

        $variants = collect([]);
        foreach ($item->variants as $v) {
            $o = new \stdClass();
            $o->id = $v->id;
            $color = $v->color->name ?? '';
            $size = $v->size->name ?? '';
            if ($color && $size)
                $o->name = $color . ' - ' . $size;
            else if ($color)
                $o->name = $color;
            else if ($size)
                $o->name = $size;
            else $o->name = 'Default';
            $o->price = $item->getPriceAttribute($v, $time);
            $variants->push($o);
        }

        return response()->json(['variants' => $variants]);
    }
#endregion


#region HELPERS
    private function getOrder($id)
    {
        return Order::with(
            'details.items.product.delivery_size',
            'details.items.product.variants.color',
            'details.items.product.variants.size',
            'billing_address',
            'details.items.product.flash_sales')
            ->with(['details.items.product.sub_category' => function ($q) {
                $q->select('id', 'vat');
            }])
            ->find($id);
    }

    private function getOrders($id)
    {
        return Order::with(
            'details.items.variant.color',
            'details.items.variant.size',
            'details.items.product',
            'details.seller',
            'billing_address.division',
            'billing_address.city',
            'billing_address.area'
        )->find($id);
    }

    private function updateBillingAddress(Request $request, $id)
    {
        BillingAddress::where('id', $id)->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'division_id' => $request->division,
            'city_id' => $request->city,
            'post_code_id' => $request->area,
            'address_line_1' => $request->address_l1,
            'address_line_2' => $request->address_l2,
        ]);
    }

    private function findAgentsAndSuggestOrder($order_id)
    {
        $billing_address = BillingAddress::whereHas('orders', function ($q) use ($order_id) {
            $q->where('id', $order_id);
        })->first();

        AgentSuggestOrder::where('order_id', $order_id)->delete();

        $success = false;

        // allocated
        $agents = $this->getAgents('post_id', $billing_address->post_code_id);
        if ($agents->count()) {
            $this->suggestOrderToAgents($agents, $order_id);
            $success = true;
        }

        if (!$success) {
            $agents = $this->getAgents('city_id', $billing_address->city_id);
            if ($agents->count()) {
                $this->suggestOrderToAgents($agents, $order_id);
                $success = true;
            }
        }

        if (!$success) {
            $agents = $this->getAgents('division_id', $billing_address->division_id);
            if ($agents->count()) {
                $this->suggestOrderToAgents($agents, $order_id);
                $success = true;
            }
        }

        // extended
        if (!$success) {
            $agents = $this->getAgents('post_id', $billing_address->post_code_id, false);
            if ($agents->count()) {
                $this->suggestOrderToAgents($agents, $order_id);
                $success = true;
            }
        }

        if (!$success) {
            $agents = $this->getAgents('city_id', $billing_address->city_id, false);
            if ($agents->count()) {
                $this->suggestOrderToAgents($agents, $order_id);
                $success = true;
            }
        }

        if (!$success) {
            $agents = $this->getAgents('division_id', $billing_address->division_id, false);
            if ($agents->count()) {
                $this->suggestOrderToAgents($agents, $order_id);
                $success = true;
            }
        }
    }

    private function getAgents($param, $match, $isAllocated = true)
    {
        return collect(Agent::whereHas($isAllocated ? 'AgentAllocatedArea' : 'AgentExtendArea',
            function ($q) use ($param, $match) {
                $q->where($param, $match);
            })->get());
    }

    private function suggestOrderToAgents($agents, $order_id)
    {
        foreach ($agents as $agent) {
            $this->suggestOrderToAgent($agent->id, $order_id);
        }
    }

    private function suggestOrderToAgent($agent_id, $order_id)
    {
        AgentSuggestOrder::create([
            'agent_id' => $agent_id,
            'order_id' => $order_id
        ]);
    }

    private function getCommonFilterData(Request $request, $types = null, $status = null)
    {
        if (!$types)
            $types = ['cash', 'gateway'];
        if (!$status)
            $status = ['Pending', 'Accepted', 'Cancelled', 'On Delivery', 'Delivered'];

        $res['order_nos'] = Order::whereIn('type', $types)
            ->whereIn('order_status', $status)
            ->select('id', 'no')
            ->get();

        $res['users'] = User::whereHas('order', function ($q) use ($types, $status) {
            $q->whereIn('type', $types)
                ->whereIn('order_status', $status)
                ->select('id', 'user_id', 'order_status');
        })
            ->select('id', 'name')
            ->get();

        $res['sellers'] = Seller::whereHas('order_details', function ($q) use ($types, $status) {
            $q->whereHas('order', function ($r) use ($types, $status) {
                $r->whereIn('type', $types)
                    ->whereIn('order_status', $status)
                    ->select('id');
            })->select('id', 'seller_id');
        })
            ->select('id', 'shop_name')
            ->get();

        if (in_array('On Delivery', $status) || in_array('Delivered', $status)) {
            $res['agents'] = Agent::whereHas('orders', function ($q) use ($types, $status) {
                $q->whereIn('type', $types)
                    ->whereIn('order_status', $status)
                    ->select('id', 'delivery_agent_id');
            })
                ->select('id', 'name')
                ->get();
        }

        return $res;
    }

    private function getFilteredOrders(Request $request, $types = ['cash', 'gateway'], $status = null)
    {
        if (!$types)
            $types = ['cash', 'gateway'];
        if (!$status)
            $status = ['Pending', 'Accepted', 'Cancelled', 'On Delivery', 'Delivered'];

        return Order
            ::with([
                'user' => function ($q) {
                    $q->select('id', 'name');
                },
                'delivery_agent' => function ($q) {
                    $q->select('id', 'name');
                }
            ])
            ->whereIn('type', $types)
            ->whereIn('order_status', $status)
            ->when($request->order, function ($q) use ($request) {
                $q->where('id', $request->order);
            })
            ->when($request->customer, function ($q) use ($request) {
                $q->where('user_id', $request->customer);
            })
            ->when($request->shop, function ($q) use ($request) {
                $q->whereHas('details', function ($r) use ($request) {
                    $r->where('seller_id', $request->shop);
                });
            })
            ->when($request->total, function ($q) use ($request) {
                $q->where('total', $request->total);
            })
            ->when($request->from_date, function ($q) use ($request) {
                $q->whereDate('order_time', '>=', $request->from_date);
            })
            ->when($request->to_date, function ($q) use ($request) {
                $q->whereDate('order_time', '<=', $request->to_date);
            })
            ->when($request->agent, function ($q) use ($request) {
                $q->where('delivery_agent_id', $request->agent);
            })
            ->select('id', 'user_id', 'delivery_agent_id', 'no', 'order_time', 'total', 'order_status', 'payment_status')
            ->orderBy('order_time', 'desc')
            ->paginate(12);
    }

    private function getSortedAgents($billing_address)
    {
        return Agent::with('AgentAllocatedArea', 'AgentExtendArea')
            ->get()
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

    private function statusGetRoute($to)
    {
        switch ($to) {
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
#endregion
}
