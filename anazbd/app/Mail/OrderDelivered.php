<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDelivered extends Mailable
{
    use Queueable, SerializesModels;

    private $order_no;
    private $name;

    public function __construct($order_no, $name)
    {
        $this->order_no = $order_no;
        $this->name = $name;
    }

    public function build()
    {
        $order = Order::with('items','user_coupon','items.product:id,name','billing_address')->where('no',$this->order_no)->first();
        return $this->view('mail.order-delivered', ['order_no' => $this->order_no, 'name' => $this->name, 'order' =>$order])
            ->subject('Order #' . $this->order_no . ' is delivered');
    }
}
