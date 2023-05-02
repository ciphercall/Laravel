<?php

namespace App\Http\Controllers\Seller;

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
            ->whereAuthSeller()
            ->latest()
            ->paginate(12);

        $orders = Order::whereHas('transactions', function ($q) {
            $q->whereAuthSeller();
        })
            ->get(['id', 'no']);

        return view('seller.transactions.index', compact('orders', 'transactions'));
    }
}
