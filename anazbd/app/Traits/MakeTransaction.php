<?php

namespace App\Traits;

use App\Models\Transaction;
use Carbon\Carbon;

trait MakeTransaction
{
    private function makeSaleTransaction($order)
    {
        foreach ($order->details as $detail) {
            $seller_amount = round($detail->total - $detail->commission, 2);
//            $total_amount = round($detail->vat + $detail->shipping_charge + $detail->total);
            $total_amount = $detail->total;
            $admin_amount = $total_amount - $seller_amount - $detail->agent_charge;
            Transaction::updateOrCreate([
                'order_id' => $order->id,
                'seller_id' => $detail->seller_id,
                'type' => 'Sale'
            ], [
                'agent_id' => $order->delivery_agent_id,
                'admin_amount' => $admin_amount < 0 ? 0 : $admin_amount,
                'seller_amount' => $seller_amount,
                'agent_amount' => $detail->agent_charge,
                'total_amount' => $total_amount,
                'status' => true
            ]);
        }
    }

    private function makeWithdrawalTransaction($withdrawal)
    {
        $withdrawal->amount *= -1;

        Transaction::updateOrCreate([
            'type' => 'Withdrawal',
            'seller_id' => $withdrawal->seller_id,
            'agent_id' => $withdrawal->agent_id,
            'withdrawal_id' => $withdrawal->id,
        ], [
            'admin_amount' => !$withdrawal->seller_id && !$withdrawal->agent_id ? $withdrawal->amount : null,
            'seller_amount' => $withdrawal->seller_id ? $withdrawal->amount : null,
            'agent_amount' => $withdrawal->agent_id ? $withdrawal->amount : null,
            'total_amount' => $withdrawal->amount,
            'status' => $withdrawal->status,
            'created_at' => Carbon::now()
        ]);
    }
}
