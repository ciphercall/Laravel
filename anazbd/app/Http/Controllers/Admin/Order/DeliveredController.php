<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Interfaces\Order\OrderInterface;
use App\Models\Agent;
use App\Models\Category;
use App\Models\Chalan;
use App\Models\ChildCategory;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderItem;
use App\Models\SubCategory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeliveredController extends Controller
{
    public function index(Request $request)
    {
        $users = Agent::whereHas('invoices', function ($q) {
            $q->where('status', 'Delivered')
                ->select('id', 'order_id', 'status');
        })
            ->select(['id', 'name'])
            ->get();
        // $customers = User::whereHas('order', function ($q) {
        //     $q->where('status', 'Delivered')
        //         ->select('id', 'user_id', 'order_status');
        //     })
        //     ->select(['id', 'name','mobile'])
        //     ->get();
        $deliveredIds = Order::where('status','Delivered')->get(['id']);

        $data['items'] = Item::whereHas('order_items',function($q) use($deliveredIds){
            $q->whereIn('order_id',$deliveredIds);
        })->get(['id','name']);

        $data['categories'] = Category::whereHas('items',function($q) use($data){
            $q->whereIn('id',$data['items']->pluck('id'));
        })->get(['id','name']);

        $data['subCategories'] = SubCategory::whereHas('items',function($q) use($data){
            $q->whereIn('id',$data['items']->pluck('id'));
        })->get(['id','name']);

        $data['childCategories'] = ChildCategory::whereHas('items',function($q) use($data){
            $q->whereIn('id',$data['items']->pluck('id'));
        })->get(['id','name']);
        // dd($items,$categories->pluck('name')->implode(','),$subCategories->pluck('name')->implode(','),$childCategories->pluck('name')->implode(','));
        $invoices = Chalan::where('status','Delivered ')
        ->when($request->user,function ($q) use($request){
            $q->where('agent_id',$request->user);
        })
        ->when($request->item_id,function($p)use($request){
            $p->whereHas('chalan_items',function($q)use($request){
                $q->where('item_id',$request->item_id);
            });
        })
        ->when($request->category_id,function($p)use($request){
            $p->whereHas('order',function($q)use($request){
                $q->whereHas('items',function($r)use($request){
                    $r->whereHas('product',function($s)use($request){
                        $s->where('category_id',$request->category_id);
                    });
                });
            });
        })
        ->when($request->sub_category_id,function($p)use($request){
            $p->whereHas('order',function($q)use($request){
                $q->whereHas('items',function($r)use($request){
                    $r->whereHas('product',function($s)use($request){
                        $s->where('sub_category_id',$request->sub_category_id);
                    });
                });
            });
        })
        ->when($request->child_category_id,function($p)use($request){
            $p->whereHas('order',function($q)use($request){
                $q->whereHas('items',function($r)use($request){
                    $r->whereHas('product',function($s)use($request){
                        $s->where('child_category_id',$request->child_category_id);
                    });
                });
            });
        })
        ->when($request->invoice_no,function ($q) use($request){
            $q->where('chalan_no','LIKE',"%".str_replace('#','',$request->invoice_no)."%");
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
            'item_id' => $request->item_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'child_category_id' => $request->child_category_id,
        ]);
        return view('admin.orders.delivered.index',compact('invoices','users','data'));
    }

    public function show(Chalan $chalan)
    {
        $chalan->load('order','order.items','order.billing_address','chalan_items');
        $data = PendingController::getAddresses($chalan->order->billing_address->division_id,$chalan->order->billing_address->city_id);
        return view('admin.orders.delivered.show',compact(['chalan','data']));
    }

    public function edit(Order $order)
    {
        $order->load(['details','user','items','billing_address', 'items.product','items.variant:id,item_id,price', 'items.seller','user_coupon','user_coupon.coupon','user_coupon.coupon.couponExtra']);
        $data = PendingController::getAddresses($order->billing_address->division_id,$order->billing_address->city_id);
        return view('admin.orders.delivered.edit',compact(['order','data']));
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
