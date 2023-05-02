<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Track\TrackingRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function tracking(TrackingRequest $request)
    {
        try {
            $user = $request->user;
            $order = Order::where('no',$request->order_id)
                    ->whereHas('user',function($q) use($user){
                        $q->where('email',$user)
                        ->orWhere('mobile', $user);
                })
                ->first();
            // dd($order);

            if($order){
                return view('frontend.pages.track',compact('order'));
            }else{
                return redirect()->to('/')->with('error', 'Sorry Not Matching!');
            }
        }catch (\Exception $e) {

        }
    }
}


