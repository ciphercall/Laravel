<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Transaction;
use App\Models\WithdrawRequest;
use App\Traits\MakeTransaction;
use Illuminate\Http\Request;

class WithdrawRequestController extends Controller
{
    use MakeTransaction;

    public function index(Request $request)
    {
        $withdrawals = WithdrawRequest::latest()
            ->whereAuthSeller()
            ->when($request->withdraw_method, function ($q) use ($request) {
                $q->where('method', $request->withdraw_method);
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->transaction_id, function ($q) use ($request) {
                $q->where('transaction_id', $request->transaction_id);
            })
            ->when($request->amount, function ($q) use ($request) {
                $q->where('amount', $request->amount);
            })
            ->when($request->date, function ($q) use ($request) {
                $q->whereDate('created_at', $request->date);
            })
            ->paginate(12);

        return view('seller.withdrawals.index', compact('withdrawals'));
    }

    public function create()
    {
        $balance = $this->getBalance();

        return view('seller.withdrawals.create', compact('balance'));
    }

    public function store(Request $request)
    {
        $balance = $this->getBalance();

        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $balance,
            'withdrawal_method' => 'required|in:bKash,Nagad,Rocket,Bank,Other',
            'mobile' => 'required',
            'transaction_id' => 'nullable',
            'note' => 'nullable'
        ]);

        WithdrawRequest::create([
            'seller_id' => auth('seller')->id(),
            'amount' => $request->amount,
            'method' => $request->withdrawal_method,
            'mobile' => $request->mobile
        ]);

        return redirect()->route('seller.withdrawal.index')->with('message', 'Request for '. $request->amount . ' TK withdrawal is successful!');
    }

    public function destroy($id)
    {
        if (WithdrawRequest::where('id', $id)->whereAuthSeller()->where('status', false)->delete()) {
            return redirect()->route('seller.withdrawal.index')->with('message', 'Withdraw request deleted successfully');
        }

        return redirect()->route('seller.withdrawal.index')->with('error', 'Withdraw request could not be deleted');
    }

    private function getBalance()
    {
        return Transaction::whereAuthSeller()->where('status', true)->whereNotNull('seller_amount')->sum('seller_amount');
    }
}
