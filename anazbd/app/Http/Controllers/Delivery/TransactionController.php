<?php

namespace App\Http\Controllers\Delivery;

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
        $agent_id = Agent::where('delivery_id', auth('delivery')->id())->first()->id ?? -1;

        $transactions = Transaction::with('order')
            ->when($request->order, function ($q) use ($request) {
                $q->where('order_id', $request->order);
            })
            ->when($request->type, function ($q) use ($request) {
                $q->where('type', $request->type);
            })
            ->when($request->amount, function ($q) use ($request) {
                $q->where('agent_amount', $request->amount);
            })
            ->when($request->date, function ($q) use ($request) {
                $q->whereDate('created_at', $request->date);
            })
            ->where('agent_id', $agent_id)
            ->latest()
            ->paginate(12);

        $orders = Order::whereHas('transactions', function ($q) use ($agent_id) {
            $q->where('agent_id', $agent_id);
        })
            ->get(['id', 'no']);

        return view('delivery.transactions.index', compact('orders', 'transactions'));
    }
}
