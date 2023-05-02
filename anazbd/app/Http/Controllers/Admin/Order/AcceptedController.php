<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Interfaces\Order\OrderInterface;
use App\Models\BillingAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\OrderService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcceptedController extends Controller implements OrderInterface
{
    use OrderService;

    public function index(Request $request)
    {
        $users = User::whereHas('order', function ($q) {
            $q->where('status', 'accepted')
                ->select('id', 'user_id', 'order_status');
        })
            ->select(['id', 'name','mobile'])
            ->get();
        $orders = Order::where('status','accepted')
            ->when($request->user,function ($q) use($request){
                $q->where('user_id',$request->user);
            })
            ->when($request->order_no,function($q)use($request){
                $q->where('no','LIKE',"%".str_replace('#','',$request->order_no)."%");
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
        return view('admin.orders.accepted.index',compact('orders','users'));
    }

    public function show(Order $order)
    {
        $order->load(['details','user','items', 'billing_address', 'items.product', 'items.variant:id,item_id,price', 'items.seller','user_coupon','user_coupon.coupon','user_coupon.coupon.couponExtra']);
        $data = PendingController::getAddresses($order->billing_address->division_id,$order->billing_address->city_id);
        return view('admin.orders.accepted.show',compact(['order','data']));
    }

    public function edit(Order $order)
    {
        $order->load(['details','user','items','billing_address', 'items.product', 'items.variant:id,item_id,price', 'items.seller','user_coupon','user_coupon.coupon','user_coupon.coupon.couponExtra']);
        $data = PendingController::getAddresses($order->billing_address->division_id,$order->billing_address->city_id);
        return view('admin.orders.accepted.edit',compact(['order','data']));
    }

    function update(Request $request,Order $order){
        $this->validate($request,[
            'name' => 'required|string',
            'mobile' => 'required|min:11',
            'email' => 'required|email',
            'billing_address_id' => 'required|numeric',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'division_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'post_code_id' => 'nullable',
            'shipping_charge' => 'nullable|numeric',
            'price.*' => 'required|numeric',
            'qty.*' => 'required|numeric'
        ]);
        try {
            DB::beginTransaction();
            //update billing address
            $order->update([
                'shipping_charge' => $request->shipping_charge == null ? 0 : $request->shipping_charge,
            ]);
            BillingAddress::find($request->billing_address_id)->update([
               'name' => $request->name,
               'mobile' => $request->mobile,
               'email' => $request->email,
               'address_line_1' => $request->address_line_1,
               'address_line_2' => $request->address_line_2,
               'division_id' => $request->division_id,
               'city_id' => $request->city_id,
               'post_code_id' => $request->post_code_id,
            ]);
            //update order items
            foreach ($request->price as $index => $data){
                $item = OrderItem::find($index);
                $item->update([
                    'price' => $data,
                    'qty' => $request->qty[$index],
                    'subtotal' => $request->qty[$index] * $data
                ]);
            }
            //update total order info
            $this->calculateOrder($order);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            dd($e);
        }

        //redirect back
        return redirect()->back()->withSuccess("Order Updated.");
    }

    function delete(Order $order)
    {
        // TODO: Implement delete() method.
    }


}
