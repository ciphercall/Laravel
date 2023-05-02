<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use App\Seller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $monthFromNow = $now->copy()->subDays(30);
        $weekFromNow = $now->copy()->subDays(7);
        $orders = Order::with('items')->whereBetween('created_at',[$monthFromNow,$now])->get();
        $weeklyOrders = $orders->filter(function ($order) use ($weekFromNow,$now){
            return Carbon::parse($order->created_at)->between($weekFromNow,$now);
        });
        $saleMonthly = [];
        $saleWeekly = [];
        for($i = 1; $i <= 30;$i++){
            $date = $monthFromNow->addDay();
            $orderForDate = $orders->filter(function($order) use($date){
                return Carbon::parse($order->created_at)->between($date->copy()->startOfDay(),$date->copy()->endOfDay());
            });
            array_push($saleMonthly,[$date->format('d') => $orderForDate->count()]);
        }
        for($i = 1; $i <= 7;$i++){
            $date = $weekFromNow->addDay();
            $orderForDate = $orders->filter(function($order) use($date){
                return Carbon::parse($order->created_at)->between($date->copy()->startOfDay(),$date->copy()->endOfDay());
            });
            array_push($saleWeekly,[$date->format('d') => $orderForDate->count()]);
        }
        $users = User::count();
        $sellers = Seller::count();
        $onDelivery = Order::where('status','On Delivery')->count();
        $pending = Order::where('status','pending')->count();
        $products = Item::where('status',true)->count();
        return view('admin.pages.dashboard',compact([
            'saleWeekly',
            'saleMonthly',
            'users',
            'sellers',
            'onDelivery',
            'pending',
            'products'
            ]));
    }
}
