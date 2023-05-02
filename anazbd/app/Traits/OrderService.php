<?php

namespace App\Traits;

use App\Models\Chalan;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;

trait OrderService
{
    /* 
        Note: this method calculates only value available on orders, order details and order items table
    */
    public function calculateOrder(Order $order){

        $items = OrderItem::where('order_id', $order->id)->where('active',true)->get(['id', 'seller_id','subtotal','vat']);
        
        // calculate items subtotal with vat and tax
        $items_total = $items->sum('subtotal');
        $vats = $items->sum('vat');

        // calculate order detail
        foreach ($items->groupBy('seller_id') as $sellerId => $data){
             OrderDetail::where('seller_id',$sellerId)->first()->update([
                'total' => $data->sum('subtotal'),
                'vat' => $data->sum('vat')
            ]);
        }

        // calculate total order
        $order->update([
            'subtotal' => $items_total,
            'total' => $items_total + $order->shipping_charge
        ]);
    }

    /* 
        Note: this method calculates only value available on chalans and chalan items table
    */
    public function calculateInvoice(Chalan $invoice)
    {
        // calculate items

        // calculate total invoice
    }
}
