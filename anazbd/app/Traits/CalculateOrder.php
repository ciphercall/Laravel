<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;

trait CalculateOrder
{
    use CalculateCoupon;

    private function calculateOrder($order_id = null)
    {
        $order = Order::where('id', $order_id)->select('id', 'order_time')->first();
        if ($order) {
            $order = Order::where('id', $order_id)
                ->with('details.items.product.sub_category', 'details.items.product.delivery_size',
                    'details.items.variant', 'billing_address', 'user_coupon')
                ->with([
                    'details.items.product.flash_sales' => function ($q) use ($order) {
                        $q->whereDateTime($order->order_time);
                    },
                    'details.items' => function ($q) {
                        $q->where('active', true);
                    },
                    'details' => function ($q) {
                        $q->whereHas('items', function ($q) {
                            $q->where('active', true);
                        });
                    }
                ])
                ->first();
        }

        if ($order) {
            return $this->calc($order);
        }

        return null;
    }

    private function calculateOrderSplitPartials($order_id = null)
    {
        $order = Order::where('id', $order_id)->first();
        $inactive_ids = OrderItem::where('order_id', $order_id)->where('active', false)->get(['id'])->pluck('id')->toArray();

        if (count($inactive_ids) > 0) {

            //-- CLONE --//

            $newOrder = $order->replicate();
            $newOrder->no = $newOrder->no . '(B)';
            $newOrder->order_status = 'Pending';
            $newOrder->save();

            $items = OrderItem::where('order_id', $order_id)
                ->whereIn('id', $inactive_ids)
                ->get();

            foreach (collect($items)->groupBy('seller_id') as $key => $group) {
                $detail = OrderDetail::create([
                    'order_id' => $newOrder->id,
                    'seller_id' => $key,
                ]);

                foreach ($group as $item) {
                    $item->update([
                        'order_id' => $newOrder->id,
                        'detail_id' => $detail->id
                    ]);
                }
            }

            $newOrder->load('details.items.product.sub_category', 'details.items.variant', 'billing_address', 'user_coupon')
                ->load([
                    'details.items.product.flash_sales' => function ($q) use ($order) {
                        $q->whereDateTime($order->order_time);
                    }
                ]);

            $this->calc($newOrder);

            //-- ORIGINAL --//

            $originalOrder = $order;
            $originalOrder->no = $originalOrder->no . '(A)';
            $originalOrder->save();

            OrderDetail::where('order_id', $order_id)->whereDoesntHave('items')->delete();

            return $this->calc($originalOrder);
        } else {
            $order->load('details.items.product.sub_category', 'details.items.variant', 'billing_address', 'user_coupon')
                ->load([
                    'details.items.product.flash_sales' => function ($q) use ($order) {
                        $q->whereDateTime($order->order_time);
                    }
                ]);
            return $this->calc($order);
        }
    }

    private function calc($order)
    {
        $item_subtotal = 0;
        $item_count = 0;
        $is_main_location = az_is_dhaka($order->billing_address->city_id);
        foreach ($order->details as $detail) {
            foreach ($detail->items as $item) {
                // $item->price = $item->product->getPriceAttribute($item->variant, $order->order_time);
                $item->subtotal = $item->price * $item->qty;
                $item_subtotal += $item->subtotal;
                $item_count++;
            }
        }
        $coupon_value = $this->calculateCouponValue($order->user_coupon->name ?? null, $item_subtotal)['value'];
        $per_coupon_subtract = round($coupon_value > 0 ? ($coupon_value / $item_count) : 0);

        $order->subtotal = 0;
        $order->total = 0;
        $order->vat = 0;
        $order->shipping_charge = 0;

        $totalMallDeliveryMain = 0;
        $totalMallAgentMain = 0;
        $totalMallDeliveryOther = 0;
        $totalMallAgentOther = 0;

        $otherDeliveryMain = 0;
        $otherDeliveryOther = 0;

        foreach ($order->details as $detail) {
            $detail->total = 0;
            $detail->vat = 0;
            $detail->commission = 0;
            $detail->shipping_charge = 0;

            $maxCustomerDhaka = 0;
            $maxCustomerOther = 0;
            $maxAgentDhaka = 0;
            $maxAgentOther = 0;
            foreach ($detail->items as $key => $item) {
                if ($detail->seller->is_anazmall_seller){
                    if ($item->product->delivery_size->customer_dhaka > $totalMallDeliveryMain){
                        $totalMallDeliveryMain = $item->product->delivery_size->customer_dhaka;
                        $maxCustomerDhaka = $item->product->delivery_size->customer_dhaka;
                    }
                    if ($item->product->delivery_size->customer_other > $totalMallDeliveryOther){
                        $totalMallDeliveryOther = $item->product->delivery_size->customer_other;
                        $maxCustomerOther = $item->product->delivery_size->customer_other;
                    }

                    if ($item->product->delivery_size->agent_dhaka > $totalMallAgentMain){
                        $totalMallAgentMain = $item->product->delivery_size->agent_dhaka;
                        $maxAgentDhaka = $item->product->delivery_size->agent_dhaka;
                    }
                    if ($item->product->delivery_size->agent_other > $totalMallAgentOther){
                        $totalMallAgentOther = $item->product->delivery_size->agent_other;
                        $maxAgentOther = $item->product->delivery_size->agent_other;
                    }

                }else{
                    if ($item->product->delivery_size->customer_dhaka > $maxCustomerDhaka){
                        $maxCustomerDhaka = $item->product->delivery_size->customer_dhaka;

                    }
                    if ($item->product->delivery_size->customer_other > $maxCustomerOther){
                        $maxCustomerOther = $item->product->delivery_size->customer_other;

                    }

                    if ($item->product->delivery_size->agent_dhaka > $maxAgentDhaka){
                        $maxAgentDhaka = $item->product->delivery_size->agent_dhaka;

                    }
                    if ($item->product->delivery_size->agent_other > $maxAgentOther){
                        $maxAgentOther = $item->product->delivery_size->agent_other;

                    }

                }

//                $item->commission = $item->subtotal * ($item->product->sub_category->commission / 100);
//                $item->vat = $item->commission * ($item->product->sub_category->vat / 100);
                $item->commission = 0;
                $item->vat = 0;
                $item->save();

                $detail->total += $item->subtotal;
//                $detail->vat += $item->vat;
//                $detail->commission += $item->commission;
                $detail->shipping_charge += $item->product->additional_delivery_charge;
            }

            if (!$detail->seller->is_anazmall_seller){
                $otherDeliveryMain += $maxCustomerDhaka;
                $otherDeliveryOther += $maxCustomerOther;
            }

            $detail->total = round($detail->total);
            $detail->vat = round($detail->vat, 2);
            $detail->commission = round($detail->commission, 2);
            $detail->shipping_charge = round($is_main_location ? $maxCustomerDhaka : $maxCustomerOther , 2);
            $detail->agent_charge = round($is_main_location ? $maxAgentDhaka : $maxAgentOther, 2);
            $detail->save();

            $order->subtotal += $detail->total;
            $order->vat += $detail->vat;
            $order->shipping_charge += $detail->shipping_charge;
            $order->agent_charge += $detail->agent_charge;
            $order->total += $detail->total;
        }

        $order->subtotal = round($order->subtotal);
//        $order->vat = round(abs(round($order->vat) - $order->vat) < 0.5 && abs(round($order->vat) - $order->vat) >= 0.01
//            ? ($order->vat + 0.5)
//            : $order->vat);
        $order->vat = 0;
        $order->total = round($order->total + $order->vat + $order->shipping_charge);
//        $order->shipping_charge = $order->details->sum('shipping_charge');
        $order->shipping_charge = $is_main_location ? ($totalMallDeliveryMain + $otherDeliveryMain) : ($totalMallDeliveryOther + $otherDeliveryOther);
        $order->agent_charge = round($order->agent_charge);
        $order->save();
        return $order;
    }
}
