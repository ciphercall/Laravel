<?php

namespace App\Http\Controllers;

use App\Mail\OrderCancelled;
use App\Mail\OrderAccepted;
use App\Mail\OrderOnDelivery;
use App\Mail\OrderNotDelivered;
use App\Mail\OrderDelivered;
use App\Traits\SMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendNotificationController extends Controller
{
    use SMS;

     public static function cancelOrderNotification($order){
        try {
            (new SendNotificationController)->sendSMS($order->billing_address->mobile, "Your order " . $order->no . " is cancelled.");
        } catch (\Exception $e) {
        }

        try {
            Mail::to($order->billing_address->email)->send(new OrderCancelled($order->no, $order->billing_address->name));
        } catch (\Exception $e) {
        }
    }
    public static function AcceptedOrderNotification($order){
        try {
            (new SendNotificationController)->sendSMS($order->billing_address->mobile, "Your order " . $order->no . " is accepted.");
        } catch (\Exception $e) {
        }
        try {
            Mail::to($order->billing_address->email)->send(new OrderAccepted($order->no, $order->billing_address->name));
        } catch (\Exception $e) {
        }
    }

    public static function onDeliveryOrderNotification($order){
        try {
            (new SendNotificationController)->sendSMS($order->billing_address->mobile, "Your order " . $order->no . " is out for delivery.");
        } catch (\Exception $e) {
        }
        try {
            Mail::to($order->billing_address->email)->send(new OrderOnDelivery($order->no, $order->billing_address->name));
        } catch (\Exception $e) {
        }
    }

    public static function notDeliveredOrderNotification($order){
        try {
            (new SendNotificationController)->sendSMS($order->billing_address->mobile, "Your order " . $order->no . " was not delivered. Please contact Anazbd.");
        } catch (\Exception $e) {
        }
        try {
            Mail::to($order->billing_address->email)->send(new OrderNotDelivered($order->no, $order->billing_address->name));
        } catch (\Exception $e) {
        }
    }

    public static function deliveredOrderNotification($order){
        try {
            (new SendNotificationController)->sendSMS($order->billing_address->mobile, "Your order " . $order->no . " was successfully delivered.");
        } catch (\Exception $e) {
        }
        try {
            Mail::to($order->billing_address->email)->send(new OrderDelivered($order->no, $order->billing_address->name));
        } catch (\Exception $e) {
        }
    }
}
