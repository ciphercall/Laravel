<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Transaction;
use App\PointTransaction;
use App\Seller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function points()
    {
        $transactions = PointTransaction::with('user:id,name,mobile')->latest()->paginate(20);
        return view('admin.transactions.points',compact('transactions'));
    }

    function index(Request $request)
    {

        $transactions = Transaction::with(['seller:id,shop_name', 'order:id,no'])
            ->when($request->order, function ($q) use ($request) {
                $q->where('order_id', $request->order);
            })
            ->when($request->shop, function ($q) use ($request) {
                $q->where('seller_id', $request->shop);
            })
            ->when($request->agent, function ($q) use ($request) {
                $q->where('agent_id', $request->agent);
            })
            ->when($request->type, function ($q) use ($request) {
                $q->where('type', $request->type);
            })
            ->when($request->total, function ($q) use ($request) {
                $q->where('total_amount', $request->total);
            })
            ->when($request->date, function ($q) use ($request) {
                $q->whereDate('created_at', $request->date);
            })
            ->where('status', true)
            ->latest()
            ->paginate(20);
        $orders = Order::has('transactions')->get(['id', 'no']);
        $sellers = Seller::has('transactions')->get(['id', 'shop_name']);
        $agents = Agent::has('transactions')->get(['id', 'name']);
        return view('admin.transactions.index', compact(['transactions', 'orders', 'sellers', 'agents']));
    }

    function create()
    {

        $order = Order::with('details')->where('status', 'Delivered')->get();
//dd($order->first()->details->first()->seller_id);
        return view('admin.transactions.create', compact(['order']));
    }

    function createPst(Request $request)
    {
        $order_details = OrderDetail::with('seller','items','items.product')->where('order_id', $request->id)->get();



        return $order_details;
    }
}
