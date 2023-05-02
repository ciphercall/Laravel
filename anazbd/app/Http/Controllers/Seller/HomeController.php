<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Division;
use App\Models\PostCode;
use App\Models\SellerBusinessAddress;
use App\Models\SellerProfile;
use App\Models\SellerReturnAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Item;
use App\Models\OrderDetail;
use App\Models\Order;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function dashboard(Request $request,$value='')
    {
        // dd($request->all());
        $seller = auth('seller')->id();
        $from = Carbon::createFromFormat('d/m/Y',$request->from_date ?? date('d/m/Y'))->startOfDay();
        $to = Carbon::createFromFormat('d/m/Y',$request->to_date ?? date('d/m/Y'))->endOfDay();

        $totalItems = Item::where('seller_id',$seller)
        ->whereBetween('created_at',[$from, $to])
        ->get();

        $orders = Order::whereHas('details',function ($q){
            $q->whereAuthSeller();
        })
        ->where('status',"!=",'Pending')
        ->whereDate('order_time', '>=', $from)
        ->whereDate('order_time', '<=', $to)
        ->get();
        // dd($from,$to,$orders);
        $soldItems = Item::where('seller_id',$seller)
        ->WhereHas('order_items', function($q) use($from,$to){
            $q->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to);
        })
        ->withCount('order_items')
        ->get();
        // dd($soldItems->first());


    	return view('seller.dashboard.index',compact(['soldItems','orders','totalItems','from','to']));
    }

    public function profile($value='')
    {

            $sellerId  = auth('seller')->id();
            $divisions = Division::all();
            $allCity   = City::all();
            $allArea   = PostCode::all();
            $seller    = SellerProfile::where('seller_id', $sellerId)->first();
            $businessAddress = SellerBusinessAddress::where('seller_id', $sellerId)->first();
            $returnAddress = SellerReturnAddress::where('seller_id', $sellerId)->first();

        return  view('seller.profile.index',
                compact('sellerId', 'divisions', 'allCity', 'allArea', 'seller', 'businessAddress', 'returnAddress'));
    }
}
