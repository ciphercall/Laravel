<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Order;
use App\Models\Transaction;
use App\Seller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction
            ::when($request->order, function ($q) use ($request) {
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
            ->paginate(12);

        $orders = Order::has('transactions')->get(['id', 'no']);
        $sellers = Seller::has('transactions')->get(['id', 'shop_name']);
        $agents = Agent::has('transactions')->get(['id', 'name']);

        return view('backend.transactions.index', compact('orders', 'sellers', 'agents', 'transactions'));
    }
}
