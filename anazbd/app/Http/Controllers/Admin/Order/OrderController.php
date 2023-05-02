<?php

namespace App\Http\Controllers\Admin\Order;

use App\DeliveredNotifyReceiver;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SendNotificationController;
use App\Models\Chalan;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderItem;
use App\Traits\DistributePoints;
use App\Traits\MakeTransaction;
use App\Traits\SMS;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use MakeTransaction,SMS,DistributePoints;

    private $internalStatuses = [
        'Pickup From Seller',
        'Arrived at Warehouse',
        'Quality Checking',
        'QC Failed',
        'Packing',
    ];

    public function deactiveItem(OrderItem $orderItem){
        $orderItem->delete();
        $this->calculateOrder($orderItem->order_id);
        return redirect()->back();
    }

    public function exportOrder(Request $request)
    {
        $orders = Order::where('status',$request->status)
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
            ->with([
                'user:id,mobile,name',
                'details:id,seller_id,order_id',
                'details.seller:id,shop_name',
                'items:id,order_id,item_id',
                'items.product:id,name'
                ])
            ->latest()->get();
        $fileName = "order_".str_replace(" ","_",strtolower($request->status))."_".Carbon::now()->format('d-m-y h:i').".csv";
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
            // "Content-Encoding"     => "UTF-8",
        );

        $columns = array('SL', 'User','Order No', 'Sellers','Items','Total','Order Date','Payment Status');

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) )); // For Unicode characters
            fputcsv($file, $columns);

            foreach ($orders as $index => $task) {
                $row['sl']  = $index + 1;
                $row['User']    = $task->user->name;
                $row['Order No']    = "#".$task->no;
                $row['Total']  = $task->total;
                $row['sellers'] = $task->details->implode('seller.shop_name',',');
                $row['items'] = $task->items->implode('product.name',',');
                $row['Order Date']  = $task->order_time;
                $row['Payment Status']  = $task->payment_status;

                fputcsv($file, array(
                    $row['sl'],
                    $row['User'],
                    $row['Order No'],
                    $row['sellers'],
                    $row['items'],
                    $row['Total'],
                    $row['Order Date'],
                    $row['Payment Status'],
                ));
            }

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportInvoice(Request $request)
    {
        $invoices = Chalan::where('status',$request->status)
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
        })
        ->when($request->order_no,function ($q) use($request){
            $q->where('order_no','LIKE',"%".str_replace('#','',$request->order_no)."%");
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
        ->with(['order:id,no,payment_status','agent:id,name'])
        ->latest()->get();
        // dd($invoices,$request->all());
        $fileName = "invoice_".$request->status == 'pending' ? 'on_delivery' : str_replace(" ","_",strtolower($request->status))."_".Carbon::now()->format('d-m-y h:i').".csv";
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
            // "Content-Encoding"     => "UTF-8",
        );

        $columns = array('SL', 'Agent','Order No', 'Invoice No', 'Total', 'Generated At');

        $callback = function() use($invoices, $columns) {
            $file = fopen('php://output', 'w');
            fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) )); // For Unicode characters
            fputcsv($file, $columns);

            foreach ($invoices as $index => $task) {
                $row['sl']  = $index + 1;
                $row['Agent']    = $task->agent->name;
                $row['Order No']    = "#".$task->order_no;
                $row['Invoice No']    = "#".$task->chalan_no;
                $row['Total']  = $task->total;
                $row['Generated At']  = $task->created_at;

                fputcsv($file, array(
                    $row['sl'],
                    $row['Agent'],
                    $row['Order No'],
                    $row['Invoice No'],
                    $row['Total'],
                    $row['Generated At'],
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    function statusUpdate(Request $request, Order $order)
    {
        $order->load('billing_address');
        $order->update(['status' => ucfirst($request->status)]);
        OrderHistory::updateOrCreate([
            'order_id' => $order->id,
            'type' => ucfirst($request->status),
        ], [
            'time' => Carbon::parse($request->delivered_at ?? date('Y-m-d'))->format('Y-m-d')
        ]);
        
        switch (ucwords($request->status)){
            case 'Accepted':
                $this->makeAccepted($order);
                break;
            case 'On Delivery':
                $this->makeOnDelivery($order);
                break;
            case 'Delivered':
                $this->makeDelivered($order);
                break;
            case 'Not Delivered':
                $this->makeNotDelivered($order);
                break;
            case 'Cancelled':
                $this->makeCancelled($order);
                break;
        }

        if (in_array($request->status,$this->internalStatuses)){
            $route = $this->getRoute($request->status);
            return redirect()->route($route);
        }

        return redirect()->route("admin.orders.".strtolower($request->status ?? 'pending').".index");
    }

    private function getRoute($status){

        switch ($status){
            case $this->internalStatuses[0] :
                return 'admin.orders.picked.index';
            case $this->internalStatuses[1]:
                return 'admin.orders.arrived.index';
            case $this->internalStatuses[2]:
                return 'admin.orders.qc.index';
            case $this->internalStatuses[4]:
                return 'admin.orders.in-packing.index';
            default:
                return 'admin.orders.pending.index';
        }
    }

    function statusUpdateChalan(Request $request,Chalan $chalan){
        $status = ucfirst($request->status);
        $date = Carbon::now();
        if($request->delivered_at != 'null'){
            $date = Carbon::parse($request->delivered_at)->format('d-m-Y');
        }
        $chalan->update([
            'status' => $status
        ]);
        if($chalan->status == "Delivered"){
            $chalan->delivered_at = $date;
            $chalan->update();
        }
        // dd($chalan->getOriginal());
        if ($status == 'Pending'){
            $status = 'on delivery';
        }elseif ($status == 'Delivered'){
            $this->completeDelivery($chalan);
        }
        return redirect()->route("admin.orders.".strtolower(str_replace(' ','-',$status) ?? 'pending').".index");
    }

    private function completeDelivery(Chalan $chalan){
        $order = Order::find($chalan->order_id);
        $order->load('details');
        // Items count
        $orderItemsCount = count($order->items);
        $chalanItemsCount = 0;
        $chalanItems = $order->chalans->loadCount('chalan_items');

        // invoice count
        $orderInvoiceCount = $order->loadCount('chalans')->chalans_count;
        $chalanDeliveredCount  = $order->chalans->where('status','Delivered')->count();

        foreach ($chalanItems as $item) {
            $chalanItemsCount += $item->chalan_items_count;
        }

        if($orderItemsCount == $chalanItemsCount && $orderInvoiceCount == $chalanDeliveredCount){
            $newRequest = new Request([
                'status' => 'Delivered',
                'delivered_at' => $chalan->delivered_at
            ]);
            $order->update([
                'payment_status' => 'Paid'
            ]);
//            $this->makeSaleTransaction($order);
            $this->statusUpdate($newRequest,$order);
        }
    }

    private function makeAccepted(Order $order){
        SendNotificationController::AcceptedOrderNotification($order);
    }

    private function makeOnDelivery(Order $order){
        SendNotificationController::onDeliveryOrderNotification($order);
    }

    private function makeDelivered(Order $order){
        SendNotificationController::deliveredOrderNotification($order);
        $user = User::findOrFail($order->user_id);
        $this->approveTransaction($user,$order);
        // send sms to important personals
        if ($order->status == "Delivered"){
            $notifyReceivers = DeliveredNotifyReceiver::where('status',true)->get();
            $invoices = Chalan::where('order_id',$order->id)->where('status','Delivered')->get();
            $delivered = OrderHistory::where('order_id',$order->id)->where('type','Delivered')->first();
            $items = OrderItem::with('product:id,name')->where('order_id',$order->id)->where('chalan',true)->select('id','order_id','chalan','item_id')->get();
            $message = "O/N: ".$order->no.".\nDelivery Date:".$delivered->created_at->format('d.m.y')."\nI/N: ".$invoices->implode('chalan_no',',')."\nItems: ".implode(',',$items->pluck('product.name')->all())."\nStatus: ".$order->status."\nQty: ".$items->count()."\nTotal: ".$invoices->sum('total');
            
            if ($notifyReceivers != null){
                foreach ($notifyReceivers as $receiver){
                    $this->sendSMSNonMask($receiver->mobile,$message);
                }
            }
        }
    }

    private function makeNotDelivered(Order $order){
        SendNotificationController::notDeliveredOrderNotification($order);
    }

    private function makeCancelled(Order $order){
        SendNotificationController::cancelOrderNotification($order);
        // send sms to important personals
        $user = User::findOrFail($order->user_id);
        $this->cancelTransaction($user,$order);
        if ($order->status == "Cancelled"){
            $notifyReceivers = DeliveredNotifyReceiver::where('status',true)->get();
            $message = "O/N: ".$order->no.".\nStatus: ".$order->status."\nTotal: ".$order->total;
            if ($notifyReceivers != null){
                foreach ($notifyReceivers as $receiver){
                    $this->sendSMSNonMask($receiver->mobile,$message);
                }
            }
        }
    }
}
