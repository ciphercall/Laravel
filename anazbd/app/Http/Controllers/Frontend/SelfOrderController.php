<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\SelfOrder;
use App\SelfOrderImage;
use App\Traits\ImageOperations;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class SelfOrderController extends Controller
{
    use ImageOperations;
    private $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    function index(){
        if ($this->agent->isMobile()){
            // return mobile page
            return view('mobile.pages.self-order');
        }
        //return desktop page
        return view('frontend.pages.self-order');
    }

    function store(Request $request){
        $this->validate($request,[
            'name' => 'required|string|min:5',
            'mobile_order' => 'required|numeric|regex:/^01[0-9]{9}$/',
            'address' => 'required|string|min:6',
        ]);
        $data = $request->only('name','mobile','address');
        $data['user_id'] = auth()->id();
        $data['mobile'] = $request->mobile_order;
        $data['status'] = "Pending";
        $order = SelfOrder::create($data);

        if ($this->agent->isMobile()){
            // return mobile page
            return view('mobile.pages.self-order',compact('order'));
        }
        //return desktop page
        return view('frontend.pages.self-order',compact('order'));
    }

    function image(Request $request,$id){
        $image = $this->saveImage('self-orders',$request->file,'self-order');
        SelfOrderImage::create([
            'self_order_id' => $id,
            'image' => $image
        ]);

    }
}
