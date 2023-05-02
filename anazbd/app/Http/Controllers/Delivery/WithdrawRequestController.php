<?php

namespace App\Http\Controllers\Delivery;

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
        $agent_id = $this->getAgentId();

        $withdrawals = WithdrawRequest::latest()
            ->where('agent_id', $agent_id)
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

        return view('delivery.withdrawals.index', compact('withdrawals'));
    }

    public function create()
    {
        $agent_id = $this->getAgentId();
        $balance = $this->getBalance($agent_id);

        return view('delivery.withdrawals.create', compact('balance'));
    }

    public function store(Request $request)
    {
        $agent_id = $this->getAgentId();
        $balance = $this->getBalance($agent_id);

        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $balance,
            'withdrawal_method' => 'required|in:bKash,Nagad,Rocket,Bank,Other',
            'mobile' => 'required',
            'transaction_id' => 'nullable',
            'note' => 'nullable'
        ]);

        WithdrawRequest::create([
            'agent_id' => $agent_id,
            'amount' => $request->amount,
            'method' => $request->withdrawal_method,
            'mobile' => $request->mobile
        ]);

        return redirect()->route('delivery.withdrawal.index')->with('message', 'Request for '. $request->amount . ' TK withdrawal is successful!');
    }

    public function destroy($id)
    {
        $agent_id = $this->getAgentId();
        if (WithdrawRequest::where('id', $id)->where('agent_id', $agent_id)->where('status', false)->delete()) {
            return redirect()->route('delivery.withdrawal.index')->with('message', 'Withdraw request deleted successfully');
        }

        return redirect()->route('delivery.withdrawal.index')->with('error', 'Withdraw request could not be deleted');
    }

    private function getBalance($agent_id)
    {
        return Transaction::where('agent_id', $agent_id)->where('status', true)->whereNotNull('agent_amount')->sum('agent_amount');
    }

    private function getAgentId()
    {
        return Agent::where('delivery_id', auth('delivery')->id())->first()->id ?? -1;
    }
}
