<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    #region PENDING
    public function pending(Request $request)
    {
        $status = ['Accepted','Pickup From Seller','Arrived at Warehouse','Quality Checking','QC Failed','Packing','On Delivery'];
        $data = $this->getCommonFilterData($status);
        $data['details'] = $this->getFilteredDetails($request, $status);

        return view('seller.order.pending-index', $data);
    }

    public function showPending($id)
    {
        $detail = $this->getDetail($id);
        return view('seller.order.show', compact('detail'));
    }
    #endregion

    #region DELIVERED
    public function delivered(Request $request)
    {
        $status = ['Delivered'];
        $data = $this->getCommonFilterData($status);
        $data['details'] = $this->getFilteredDetails($request, $status);

        return view('seller.order.delivered-index', $data);
    }

    public function showDelivered($id)
    {
        $detail = $this->getDetail($id);
        return view('seller.order.show', compact('detail'));
    }
    #endregion

    #region CANCELLED
    public function cancelled(Request $request)
    {
        $status = ['Cancelled'];
        $data = $this->getCommonFilterData($status);
        $data['details'] = $this->getFilteredDetails($request, $status);
        return view('seller.order.cancelled-index', $data);
    }

    public function showCancelled($id)
    {
        $detail = $this->getDetail($id);
        return view('seller.order.show', compact('detail'));
    }
    #endregion

    #region HELPERS
    private function getCommonFilterData($status = [])
    {
        $data['orders'] = Order::whereHas('details', function ($q) {
            $q->whereAuthSeller()
                ->select('id');
        })
            ->whereIn('status', $status)
            ->get(['id', 'no']);
        $data['items'] = Item::whereAuthSeller()
            ->whereHas('order_items', function ($q) use ($status) {
                $q->whereHas('detail', function ($q) use ($status) {
                    $q->whereAuthSeller()
                        ->select('id', 'detail_id')
                        ->whereHas('order', function ($q) use ($status) {
                            $q->whereIn('status', $status);
                        });
                })->select('id', 'item_id');
            })
            ->get(['id', 'name']);

        return $data;
    }

    private function getFilteredDetails(Request $request, $status = [])
    {
        return OrderDetail::whereAuthSeller()
            ->with(['items.variant' => function ($q) {
                $q->select('id', 'item_id');
            }])
            ->with(['items.variant.color' => function ($q) {
                $q->select('id', 'name');
            }])
            ->with(['items.variant.size' => function ($q) {
                $q->select('id', 'name');
            }])
            ->with(['items.product' => function ($q) {
                $q->select('id', 'name');
            }])
            ->with(['order' => function ($q) {
                $q->select('id', 'no', 'order_time');
            }])
            ->whereHas('order', function ($q) use ($status) {
                $q->whereIn('status', $status);
            })
            ->when($request->order, function ($q) use ($request) {
                $q->whereHas('order', function ($r) use ($request) {
                    $r->where('no', $request->order);
                });
            })
            ->when($request->from_date, function ($q) use ($request) {
                $q->whereHas('order', function ($r) use ($request) {
                    $r->whereDate('order_time', '>=', $request->from_date);
                });
            })
            ->when($request->to_date, function ($q) use ($request) {
                $q->whereHas('order', function ($r) use ($request) {
                    $r->whereDate('order_time', '<=', $request->to_date);
                });
            })
            ->when($request->item, function ($q) use ($request) {
                $q->whereHas('items', function ($r) use ($request) {
                    $r->where('item_id', $request->item);
                });
            })
            ->when($request->qty, function ($q) use ($request) {
                $q->has('items', '=', $request->qty);
            })
            ->when($request->total, function ($q) use ($request) {
                $q->where('total', $request->total);
            })
            ->withCount('items')
            ->latest()
            ->paginate(12);
    }

    private function getDetail($id)
    {
        return OrderDetail::whereAuthSeller()
            ->with(['items.variant' => function ($q) {
                $q->select('id', 'item_id');
            }])
            ->with(['items.variant.color' => function ($q) {
                $q->select('id', 'name');
            }])
            ->with(['items.variant.size' => function ($q) {
                $q->select('id', 'name');
            }])
            ->with(['items.product' => function ($q) {
                $q->select('id', 'name');
            }])
            ->with(['order' => function ($q) {
                $q->select('id', 'no', 'order_time');
            }])
            ->where('id', $id)
            ->withCount('items')
            ->first();
    }
    #endregion
}
