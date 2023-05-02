<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Interfaces\Order\OrderInterface;
use App\Models\Agent;
use App\Models\Chalan;
use App\Models\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OnDeliveryController extends Controller
{
    public function index(Request $request)
    {
        $users = Agent::whereHas('invoices', function ($q) {
            $q->where('status', 'Pending')
                ->select('id', 'order_id', 'status');
            })
            ->select(['id', 'name'])
            ->get();
        $invoices = Chalan::where('status','Pending')
            ->when($request->user,function ($q) use($request){
                $q->where('agent_id',$request->user);
            })
            ->when($request->invoice_no,function ($q) use($request){
                $q->where('chalan_no','LIKE',"%".str_replace('#','',$request->chalan_no)."%");
                // $q->where('chalan_no',str_replace('#','',$request->invoice_no));
            })
            ->when($request->order_no,function ($q) use($request){
                $q->where('order_no','LIKE',"%".str_replace('#','',$request->order_no)."%");
                // $q->where('order_no',str_replace('#','',$request->order_no));
            })
            ->when($request->from,function ($q) use($request){
                $q->whereDate('created_at','>=',$request->from);
            })
            ->when($request->to,function ($q) use($request){
                $q->whereDate('created_at','<=',$request->to);
            })
            ->when($request->total,function ($q) use($request){
                $q->where('total',$request->total);
            })
            ->when($request->total,function ($q) use($request){
                $q->where('total',$request->total);
            })
            ->when($request->mobile,function($q) use ($request){
                $q->whereHas('order',function($r) use ($request){
                    $r->whereHas('billing_address',function($s) use ($request){
                        $s->where('mobile',$request->mobile);
                    });
                });
                
            })
            ->when($request->price_to,function($q) use ($request){
                $q->where('total','<=',$request->price_to);
            })
            ->when($request->price_from,function($q) use ($request){
                $q->where('total','>=',$request->price_from);
            })
            ->when($request->payment_status,function($q) use ($request){
                $q->whereHas('order',function($r) use ($request){
                    $r->where('payment_status',$request->payment_status);
                });
            })
            ->when($request->order_date,function ($q) use($request){
                $q->whereHas('order',function($r) use ($request){
                    $r->whereBetween('order_time',[Carbon::parse($request->order_date),Carbon::parse($request->order_date)->endOfDay()]);
                });
            })
            ->with(['order:id,no,payment_status'])
            ->latest()
            ->paginate(15)->appends([
                'user' => $request->user,
                'from' => $request->from,
                'to' => $request->to,
                'total' => $request->total,
                'price_from' => $request->price_from,
                'price_to' => $request->price_to,
                'order_date' => $request->order_date,
                'mobile' => $request->mobile,
                'order_no' => $request->order_no,
                'invoice_no' => $request->invoice_no,
            ]);
        return view('admin.orders.ondelivery.index',compact('invoices','users'));
    }

    public function show(Chalan $chalan)
    {
        $chalan->load('order','order.items','order.billing_address','chalan_items');
        $data = PendingController::getAddresses($chalan->order->billing_address->division_id,$chalan->order->billing_address->city_id);
        return view('admin.orders.ondelivery.show',compact(['chalan','data']));
    }

    public function edit(Chalan $chalan)
    {
        $chalan->load('order','order.items','order.billing_address','chalan_items');
        $data = PendingController::getAddresses($chalan->order->billing_address->division_id,$chalan->order->billing_address->city_id);
        return view('admin.orders.ondelivery.edit',compact(['chalan','data']));
    }

    function update(Request $request, Order $order)
    {
        // TODO: Implement update() method.
    }

    function delete(Order $order)
    {
        // TODO: Implement delete() method.
    }
}
