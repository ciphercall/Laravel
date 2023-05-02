<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
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
            ->when($request->withdraw_method, function ($q) use ($request) {
                $q->where('method', $request->withdraw_method);
            })
            ->when($request->status, function ($q) use ($request) {
                $q->where('is_approved', $request->status);
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

        return view('backend.withdrawals.index', compact('withdrawals'));
    }

    public function create()
    {
        $balance = $this->getAdminBalance();

        return view('backend.withdrawals.create', compact('balance'));
    }

    public function store(Request $request)
    {
        $balance = $this->getAdminBalance();

        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $balance,
            'method' => 'required|in:bKash,Nagad,Rocket,Bank,Other',
            'transaction_id' => 'nullable',
            'note' => 'nullable'
        ]);

        $isAdmin = !$request->seller_id && !$request->agent_id;

        $withdrawal = WithdrawRequest::create([
            'seller_id' => $request->seller_id,
            'agent_id' => $request->agent_id,
            'amount' => $request->amount,
            'is_approved' => $isAdmin
        ]);

        $this->makeWithdrawalTransaction($withdrawal);

        return redirect()->route('backend.withdrawal.index')->with('message', $request->amount . ' withdrawn successfully!');
    }

    public function edit($id)
    {
        $withdrawal = WithdrawRequest::with('agent', 'seller')->find($id);

        if ($withdrawal->agent_id)
            $balance = $this->getAgentBalance($withdrawal->agent_id);
        else if ($withdrawal->seller_id)
            $balance = $this->getSellerBalance($withdrawal->seller_id);
        else
            $balance = $this->getAdminBalance();

        return view('backend.withdrawals.edit', compact('withdrawal', 'balance'));
    }

    public function update(Request $request, $id)
    {
        $withdrawal = WithdrawRequest::find($id);

        if ($withdrawal->status && $withdrawal->agent_id)
            $balance = $withdrawal->amount + $this->getAgentBalance($withdrawal->agent_id);
        else if (!$withdrawal->status && $withdrawal->agent_id)
            $balance = $this->getAgentBalance($withdrawal->agent_id);
        else if ($withdrawal->status && $withdrawal->seller_id)
            $balance = $withdrawal->amount + $this->getSellerBalance($withdrawal->seller_id);
        else if (!$withdrawal->status && $withdrawal->seller_id)
            $balance = $this->getSellerBalance($withdrawal->seller_id);
        else if ($withdrawal->status)
            $balance = $withdrawal->amount + $this->getAdminBalance();
        else
            $balance = $this->getAdminBalance();

        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $balance,
            'withdrawal_method' => 'required|in:bKash,Nagad,Rocket,Bank,Other',
            'transaction_id' => 'nullable',
            'mobile' => 'nullable',
            'note' => 'nullable'
        ]);

        $withdrawal->status = $request->status;
        $withdrawal->transaction_id = $request->transaction_id;
        $withdrawal->mobile = $request->mobile;
        $withdrawal->amount = $request->amount;
        $withdrawal->method = $request->withdrawal_method;
        $withdrawal->save();

        $this->makeWithdrawalTransaction($withdrawal);

        return redirect()->route('backend.withdrawal.index')->with('message', 'Withdrawal updated successfully!');
    }

    public function destroy($id)
    {
        if (WithdrawRequest::where('id', $id)->where('status', false)->delete()) {
            return redirect()->route('backend.withdrawal.index')->with('message', 'Withdraw request deleted successfully');
        }

        return redirect()->route('backend.withdrawal.index')->with('error', 'Withdraw request could not be deleted');
    }

    private function getAdminBalance()
    {
        return Transaction::whereNotNull('admin_amount')->sum('admin_amount');
    }

    private function getAgentBalance($agent_id)
    {
        return Transaction::where('agent_id', $agent_id)->where('status', true)->whereNotNull('agent_amount')->sum('agent_amount');
    }

    private function getSellerBalance($seller_id)
    {
        return Transaction::where('seller_id', $seller_id)->where('status', true)->whereNotNull('seller_amount')->sum('seller_amount');
    }
}
