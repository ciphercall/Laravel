<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PickedUpController extends Controller
{
    private $status = 'Pickup From Seller';
    function index(Request $request){
        $users = User::whereHas('order', function ($q) {
            $q->where('status', $this->status)
                ->select('id', 'user_id', 'status');
        })
            ->select(['id', 'name','mobile'])
            ->get();
        $orders = Order::with([
            'billing_address:id,name',
            'items:id,order_id,item_id',
            'items.product:id,name,slug',
            'details:id,seller_id,order_id',
            'details.seller:id,shop_name'
        ])
            ->where('status',$this->status)
            ->when($request->user,function ($q) use($request){
                $q->where('user_id',$request->user);
            })
            ->when($request->order_no,function($q)use($request){
                $q->where('no','LIKE',"%".str_replace('#','',$request->order_no)."%");
                // $q->where('no',str_replace('#','',$request->order_no));
            })
            ->when($request->from,function ($q) use($request){
                $q->whereDate('order_time','>=',$request->from);
            })
            ->when($request->to,function ($q) use($request){
                $q->whereDate('order_time','<=',$request->to);
            })
            ->when($request->total,function ($q) use($request){
                $q->where('total',$request->total);
            })
            ->when($request->mobile,function($q) use ($request){
                $q->whereHas('billing_address',function($r) use ($request){
                    $r->where('mobile',$request->mobile);
                });
            })
            ->when($request->price_to,function($q) use ($request){
                $q->where('total','<=',$request->price_to);
            })
            ->when($request->price_from,function($q) use ($request){
                $q->where('total','>=',$request->price_from);
            })
            ->when($request->payment_status,function($q) use ($request){
                $q->where('payment_status',$request->payment_status);
            })
            ->when($request->order_date,function ($q) use($request){
                $q->whereBetween('order_time',[Carbon::parse($request->order_date),Carbon::parse($request->order_date)->endOfDay()]);
            })
            ->with(['user:id,mobile,name'])
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
            ]);
        return view('admin.orders.pickup.index',compact('orders','users'));
    }
}
