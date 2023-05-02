<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryDateEnhancedController extends Controller
{
    function index(Request $request){
        $orders = Order::where('status','Delivered Date Enhanced')->paginate(20);
        dd($orders);
    }
}
