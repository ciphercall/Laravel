<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SelfOrder;
use Illuminate\Http\Request;

class SelfOrderController extends Controller
{
    function index(){
        $orders = SelfOrder::withCount('images')->latest()->paginate('15');
        return view('admin.self-orders.index',compact('orders'));
    }

    function show($id){
        $order = SelfOrder::findOrFail($id);
        $order->load('images');
        return view('admin.self-orders.show',compact('order'));
    }
}
