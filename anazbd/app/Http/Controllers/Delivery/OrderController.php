<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentSuggestOrder;
use App\Models\City;
use App\Models\Division;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\PostCode;
use App\Seller;
use App\Traits\MakeTransaction;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use MakeTransaction;

#region NEW
    public function new(Request $request)
    {
        $data = $this->getCommonFilterData($request, null, ['Accepted']);
        $data['orders'] = $this->getFilteredOrders($request, null, ['Accepted']);

        return view('delivery.orders.new-index', $data);
    }

    public function showNew($no)
    {
        $order = Order::with(
            'details.items.variant.color',
            'details.items.variant.size',
            'details.items.product',
            'details.seller',
            'billing_address.division',
            'billing_address.city',
            'billing_address.area'
        )
            ->where('no', $no)
            ->first();

        return view('delivery.orders.new-show', compact('order'));
    }

    public function accept($no)
    {
        $order = Order::where('no', $no)->first();

        if (!$order->delivery_agent_id) {
            $order->order_status = 'On Delivery';
            $order->delivery_agent_id = Agent::where('delivery_id', auth('delivery')->id())->first()->id;
            $order->save();

            OrderHistory::updateOrCreate([
                'order_id' => $order->id,
                'type' => 'On Delivery',
            ], [
                'time' => date('Y-m-d H:i:s')
            ]);

            AgentSuggestOrder::where('order_id', $order->id)->delete();

            return redirect()->route('delivery.orders.new-index')->with('message', 'Order is successfully accepted!');
        }

        return redirect()->route('delivery.orders.new-index')->with('error', 'Taken by another agent!');
    }
#endregion

#region ON DELIVERY
    public function onDelivery(Request $request)
    {
        $data = $this->getCommonFilterData($request, null, ['On Delivery']);
        $data['orders'] = $this->getFilteredOrders($request, null, ['On Delivery']);

        return view('delivery.orders.on-delivery-index', $data);
    }

    public function showOnDelivery($no)
    {
        $order = Order::with(
            'details.items.variant.color',
            'details.items.variant.size',
            'details.items.product',
            'details.seller',
            'billing_address.division',
            'billing_address.city',
            'billing_address.area'
        )
            ->where('no', $no)
            ->first();

        return view('delivery.orders.on-delivery-show', compact('order'));
    }

    public function deliverySuccess($no)
    {
        $order = Order::where('no', $no)->first();

        $order->order_status = 'Delivered';
        $order->payment_status = 'Paid';
        $order->delivery_date = date('Y-m-d H:i:s');
        $order->save();

        $this->makeSaleTransaction($order);

        OrderHistory::updateOrCreate([
            'order_id' => $order->id,
            'type' => 'Delivered',
        ], [
            'time' => date('Y-m-d H:i:s')
        ]);

        return redirect()->route('delivery.orders.on-delivery-index')->with('message', 'Delivery status set to successful!');
    }

    public function deliveryError($no)
    {
        $order = Order::where('no', $no)->first();

        $order->order_status = 'Not Delivered';
        $order->save();

        return redirect()->route('delivery.orders.on-delivery-index')->with('message', 'Delivery status set to unsuccessful!');
    }
#endregion

#region DELIVERED
    public function delivered(Request $request)
    {
        $data = $this->getCommonFilterData($request, null, ['Delivered']);
        $data['orders'] = $this->getFilteredOrders($request, null, ['Delivered']);

        return view('delivery.orders.delivered-index', $data);
    }

    public function showDelivered($no)
    {
        $order = Order::with(
            'details.items.variant.color',
            'details.items.variant.size',
            'details.items.product',
            'details.seller',
            'billing_address.division',
            'billing_address.city',
            'billing_address.area'
        )
            ->where('no', $no)
            ->first();

        return view('delivery.orders.delivered-show', compact('order'));
    }
#endregion

#region HELPERS
    private function getCommonFilterData(Request $request, $types = null, $status = null)
    {
        if (!$types)
            $types = ['cash', 'gateway'];
        if (!$status)
            $status = ['Pending', 'Accepted', 'Cancelled', 'On Delivery', 'Delivered'];

        $res['order_nos'] = Order::whereIn('type', $types);

        if (in_array('Accepted', $status))
            $res['order_nos'] = $res['order_nos']->whereHas('agent_suggest_orders', function ($q) {
                $q->whereAuthAgent();
            });
        else
            $res['order_nos'] = $res['order_nos']->whereHas('delivery_agent', function ($q) {
                $q->where('id', Agent::where('delivery_id', auth('delivery')->id())->first()->id);
            });

        $res['order_nos'] = $res['order_nos']->whereIn('order_status', $status)
            ->select('id', 'no')
            ->get();

        $res['users'] = User::whereHas('order', function ($q) use ($types, $status) {
            $q->whereIn('type', $types)
                ->whereIn('order_status', $status)
                ->select('id', 'user_id', 'order_status');
        })
            ->select('id', 'name')
            ->get();

        $res['divisions'] = Division::orderBy('id')->get(['id', 'name']);
        $res['cities'] = City::where('division_id', $request->division ?? -1)->get(['id', 'name']);
        $res['areas'] = PostCode::where('city_id', $request->city ?? -1)->get(['id', 'name']);

        return $res;
    }

    private function getFilteredOrders(Request $request, $types = null, $status = null)
    {
        if (!$types)
            $types = ['cash', 'gateway'];
        if (!$status)
            $status = ['Pending', 'Accepted', 'Cancelled', 'On Delivery', 'Delivered'];

        $orders = Order::with([
            'user' => function ($q) {
                $q->select('id', 'name');
            },
        ]);

        if (in_array('Accepted', $status))
            $orders = $orders->whereHas('agent_suggest_orders', function ($q) {
                $q->whereAuthAgent();
            });
        else
            $orders = $orders->whereHas('delivery_agent', function ($q) {
                $q->where('id', Agent::where('delivery_id', auth('delivery')->id())->first()->id);
            });

        return $orders->with('billing_address.division', 'billing_address.city', 'billing_address.area')
            ->whereIn('type', $types)
            ->whereIn('order_status', $status)
            ->when($request->order, function ($q) use ($request) {
                $q->where('id', $request->order);
            })
            ->when($request->customer, function ($q) use ($request) {
                $q->where('user_id', $request->customer);
            })
            ->when($request->division, function ($q) use ($request) {
                $q->whereHas('billing_address', function ($r) use ($request) {
                    $r->where('division_id', $request->division);
                });
            })
            ->when($request->city, function ($q) use ($request) {
                $q->whereHas('billing_address', function ($r) use ($request) {
                    $r->where('city_id', $request->city);
                });
            })
            ->when($request->area, function ($q) use ($request) {
                $q->whereHas('billing_address', function ($r) use ($request) {
                    $r->where('post_code_id', $request->area);
                });
            })
            ->when($request->date, function ($q) use ($request) {
                $q->whereDate('order_time', $request->date);
            })
            ->select('id', 'user_id', 'delivery_agent_id', 'no', 'order_time', 'total', 'order_status', 'payment_status', 'billing_address_id')
            ->orderBy('order_time', 'desc')
            ->paginate(12);
    }
#endregion

#region MISC AJAX
    public function citiesAjax(Request $request)
    {
        $cities = City::where('division_id', $request->division)->get(['id', 'division_id', 'name']);
        return response()->json(['cities' => $cities]);
    }

    public function areasAjax(Request $request)
    {
        $areas = PostCode::where('city_id', $request->city)->get(['id', 'city_id', 'name']);
        return response()->json(['areas' => $areas]);
    }
#endregion
}
