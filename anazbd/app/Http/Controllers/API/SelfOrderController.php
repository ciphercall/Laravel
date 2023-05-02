<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\SelfOrder;
use App\SelfOrderImage;
use App\Traits\ImageOperations;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as ImageUploader;

class SelfOrderController extends Controller
{
    use ImageOperations;

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|min:5',
            'mobile' => 'required|numeric|regex:/^01[0-9]{9}$/',
            'address' => 'required|string|min:6',
        ]);
        $data = $request->only('name','mobile','address');
        $data['user_id'] = auth('api')->check() ? auth('api')->id() : null;
        // $data['mobile'] = $request->mobile_order;
        $data['status'] = "Pending";
        $order = SelfOrder::create($data);

        if($request->has('images') && is_array($request->images)){
            foreach($request->images as $item){
                SelfOrderImage::create([
                    'self_order_id' => $order->id,
                    'image' => $this->saveImage('self-orders',ImageUploader::make($item),'self-order',false,"none")
                ]);
                // SelfOrderImage::create([
                //     'self_order_id' => $order->id,
                //     'image' => $this->saveImage('self-orders',$item,'self-order')
                // ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'Order Placed Successfully.',
            'data' => []
        ]);
    }
}
