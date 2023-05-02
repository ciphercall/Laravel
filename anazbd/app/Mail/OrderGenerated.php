<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderGenerated extends Mailable
{
    use Queueable, SerializesModels;

    private $order;
    private $name;
    private $items;

    public function __construct($order, $name,$items)
    {
        $this->order = $order;
        $this->name = $name;
        $this->items = $items;
    }

    public function build()
    {
        $this->order->load('items','user_coupon','items.product:id,name','billing_address');
        return $this->view('mail.order-invoice', ['order_no' => $this->order->no, 'name' => $this->name,'order' => $this->order, 'items' => $this->items])
            ->subject('New order #' . $this->order->no);
    }
}
