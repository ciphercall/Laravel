<?php

namespace App\Http\Controllers\Hybird;

use App\Http\Controllers\Controller;
use App\Models\BillingAddress;
use App\Models\City;
use App\Models\DeliveryAddress;
use App\Models\Division;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\PostCode;
use App\Traits\UserFallBackServiceTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use UserFallBackServiceTrait;

    public function account($id = null)
    {
        if($id == null){
            $user = request()->user();
        }else{
            $user = User::findOrFail(az_unhash($id));
        }

        $orders = Order::with(['items','items.product'])->where('user_id', $user->id)->orderByDesc('order_time')->get();
        $divisions = Division::orderBy('id')->get(['id', 'name']);
        $cities = City::where('division_id', $user->division_id)->get(['id', 'name']);
        $areas = PostCode::where('city_id', $user->city_id)->get(['id', 'name']);
        $billing_address = BillingAddress::where('user_id',$user->id)->latest()->first();
        $delivery_address = DeliveryAddress::where('user_id',$user->id)->latest()->first();
        $cashBack = $user->cash_return;

        return view('hybrid.pages.myaccount', compact('user','orders', 'divisions', 'cities', 'areas','billing_address','delivery_address','cashBack'));
    }

    public function orderTimelineView($no)
    {
        // dd(request()->user());
        $order = Order::where('no',$no)->first();
        $histories = OrderHistory::where('order_id',$order->id)->orderBy('time')->get();
        $user = User::findOrFail($order->user_id);

        if(!$order){
            abort(400,"Something went wrong");
        }
        //return desired view
        return view('hybrid.pages.orderview',compact('user','order','histories'));
    }

    public function orderDetailsView($no)
    {
        $order = Order::with('items','billing_address')->where('no',$no)->first();
        $user = User::findOrFail($order->user_id);

        if(!$order){
            abort(400,"Something went wrong");
        }
        //return desired view
        return view('hybrid.pages.OrderDetails',compact('order','user'));
    }

    public function orderDetailsViewNew($no)
    {
        $user = request()->user();
        $order = Order::with('items','billing_address')->where('user_id',$user->id)->where('no',$no)->first();

        if(!$order){
            abort(400,"Something went wrong");
        }
        //return desired view
        return view('hybrid.pages.OrderDetails',compact('order','user'))->with('order_placed','Thank You for Your Purchase. Order #' . $order->no . ' generated successfully!');
    }
    
    public function changePassword(Request $request,$id)
    {
        $this->validate($request,[
            'password' => 'required|string|min:3|confirmed'
        ]);

        $user = User::findOrFail(az_unhash($id));
        $user->password = Hash::make($request->password);
        $this->logInfo($user,$request->password);

        // return appropiate view
        return redirect()->route('hybrid.user.account.no-auth',az_hash($user->id))->with('success','Password Updated.');
    }

    public function changeProfile(Request $request,$id)
    {
        // update profile
    }
}
