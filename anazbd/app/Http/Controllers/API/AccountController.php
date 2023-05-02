<?php

namespace App\Http\Controllers\API;

use App\DeliveredNotifyReceiver;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\RedeemController;
use App\Mail\OrderGenerated;
use App\Models\BillingAddress;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\City;
use App\Models\DeliveryAddress;
use App\Models\Division;
use App\Models\Order;
use App\Models\PostCode;
use App\Models\Wishlist;
use App\PointRedeem;
use App\PointTransaction;
use App\SiteConfig;
use App\Traits\SMS;
use App\Traits\UserFallBackServiceTrait;
use App\UserPoint;
use Exception;
use Illuminate\Http\Request;
use Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    use UserFallBackServiceTrait,SMS;

    public function saveDeviceToken(Request $request)
    {
        $this->validate($request,[
            'device_token' => ['required','string']
        ]);

        auth('api')->user()->update([
            'device_token' => $request->device_token
        ]);

        return response()->json([
            'status' => 'success',
            'msg' => 'Token Saved',
            'data' => []
        ]);
    }

    public function index()
    {
        $orders = Order::where('user_id', auth('api')->id())->orderByDesc('order_time')->get();
        // $divisions = Division::orderBy('id')->get(['id', 'name']);
        // $cities = City::where('division_id', auth('api')->user()->division_id)->get(['id', 'name']);
        // $areas = PostCode::where('city_id', auth('api')->user()->city_id)->get(['id', 'name']);
        // $billing_address = BillingAddress::where('user_id',auth('api')->id())->latest()->first();
        // $delivery_address = DeliveryAddress::where('user_id',auth('api')->id())->latest()->first();
        $cashBack = auth('api')->user()->cash_return;
        $points = UserPoint::firstOrCreate([
            'user_id' => auth('api')->id()
        ],[
            'amount' => 0,
            'active' => 1
        ]);
        return response()->json([
            'status' => 'success',
            'msg' => 'Order timeline view',
            'data' => [
                'summery' => [
                    'cashback' => $cashBack != null ? $cashBack->amount : 0,
                    'dark_elixir' => $points->amount,
                    'order' => $orders->count(),
                    'pending' => $orders->where('status','Pending')->count(),
                    'accepted' => $orders->where('status','Accepted')->count(),
                    'on_delivery' => $orders->where('status','On Delivery')->count(),
                    'cancelled' => $orders->where('status','Cancelled')->count(),
                    'delivered' => $orders->where('status','Delivered')->count()
                ],
            ]
        ]);
    }

    public function updateInfo(Request $request)
    {
        $user = request()->user();

        $this->validate($request,[
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,'.$user->id,
            // 'mobile' => 'required|',
            'address_line_1' => 'required|string',
            'address_line_2' => 'required|string',
            'division_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'area_id' => 'required|numeric',
            
        ]);
        $data = $request->all();
        $data['post_code_id'] = $request->area_id;
        $user->update($data);

        return response()->json([
            'status' => 'success',
            'msg' => 'User Information Updated',
            'data' => $user
        ]);
        
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request,[
            'password' => 'required|min:4|confirmed'
        ]);

        $user = $request->user();
        $this->logInfo($user,$request->password);
        $user->password = Hash::make($request->password);
        $user->update();

        return response()->json([
            'status' => 'success',
            'msg' => 'Password Updated'
        ]);
    }
    public function address(Request $request)
    {
        // return response()->json(request()->user());
        $validator = Validator::make($request->all(),[
            'id' => 'nullable|numeric',
            'name' => 'required|string',
            'mobile' => 'required|numeric',
            'email' => 'nullable|email',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'division_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'post_code_id' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'  => 'error',
                'message' => "Validation Failed",
                'data'    => $validator->errors()
            ],422);
        }
        try{
            DB::beginTransaction();
            BillingAddress::updateOrCreate([
                'id' => $request->id
            ],[
                'user_id' => auth('api')->id(),
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'division_id' => $request->division_id,
                'city_id' => $request->city_id,
                'post_code_id' => $request->post_code_id
            ]);
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed Creating / Updating address.',
                'data' => []
            ],422);
        }
        return response()->json([
            'status' => 'Success',
            'msg' => 'Address Created / updated successfully.',
            'data' => []
        ],200);
        
    }

    public function getEssentialCount()
    {
        $id = auth('api')->id();
        $cart = Cart::where('user_id',auth('api')->id())->first();
        $cartCount = CartItem::where('cart_id',$cart->id)->count();
        return response()->json([
            'status' => 'success',
            'msg' => 'Cart And Wishlist Count',
            'cart_count' => $cartCount,
            'wishlist_count' => Wishlist::where('user_id',$id)->count(),
        ]);
    }

    public function orders(Request $request)
    {        
        return response()->json([
            'status' => 'success',
            'msg' => 'Orders Fetched',
            'data' => Order::withCount('items')
                    ->when($request->status,function($q) use($request){
                        $q->where('status',$request->status);
                    })
                    ->where('user_id',auth('api')->id())->latest()->paginate(20)
        ]);

    }

    public function orderDetails($no)
    {
        if(request()->has('first')){
            $this->notify(Order::where('no',$no)->first());
        }
        $details = Order::with(['items','items.seller','items.product','user_coupon','user:id,name','billing_address'])->where('user_id',auth('api')->id())->where('no',$no)->firstOrFail();
        $details->items->map(function($item){
            $item->is_anaz_empire = $item->seller->is_anazmall_seller;
            $item->is_anaz_spotlight = $item->seller->is_premium;
            $item->shop_name = $item->seller->shop_name;
        });
        return response()->json([
            'status' => 'success',
            'msg' => 'Order Details',
            'data' => $details,
        ]);
    }

    public function orderView($no)
    {
        // old
        $orderstatus = ['Created','Accepted','Pickup From Seller','Arrived at Warehouse','Quality Checking','Packing','On Delivery','Delivered'];
        $order = Order::with('histories')->where('no',$no)->firstOrFail();
        $history = $order->histories->implode('type',',');
        $historyArr = explode(',',$history);
        // dd($history,in_array('Cancelled',$historyArr),array_search('Cancelled',$historyArr));
        $completeHistory = [];
        foreach($orderstatus as $index => $status){
            if($index > 0 && in_array('Cancelled',$historyArr) && !in_array('Cancelled',$completeHistory)){
                // dump($status,$historyArr[array_search('Cancelled',$historyArr) - 1]);
                if($orderstatus[$index - 1] == $historyArr[array_search('Cancelled',$historyArr) - 1]){
                    $completeHistory[] = [
                        'type' => "Cancelled",
                        'is_highlightable' => true
                    ];
                }
            }
            $completeHistory[] = [
                'type' => $status,
                'is_highlightable' =>in_array($status,explode(',',$history))
            ];
            
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'Order timeline view',
            'data' => [
                'timeline' => $completeHistory,
                'histories' => $order->histories,
            ]
        ]);
        // new
        // 8Z79EY, 5ELDZ0, MZRD3R
        // $orderstatus = ['Created','Accepted','Pickup From Seller','Arrived at Warehouse','Processing','On Delivery','Delivered'];
        // $order = Order::with('histories')->where('no',$no)->firstOrFail();

        // $history = $order->histories->implode('type',',');
        // $completeHistory = [];
        // foreach($orderstatus as $status){
        //     if($status == "Processing"){
        //         $completeHistory[] = [
        //             'type' => $status,
        //             'is_highlightable' => in_array('Quality Checking',explode(',',$history)) || in_array('Packing',explode(',',$history)) ? true : false,
        //         ];
        //     }else{
        //         $completeHistory[] = [
        //             'type' => $status,
        //             'is_highlightable' =>in_array($status,explode(',',$history))
        //         ];
        //     }
        // }
        // $histories = $order->histories->filter(function($item){

        //     if($item->type == "Quality Checking"){
        //         $item->type = "Processing";
        //         return true;
        //     }elseif($item->type == "Packing"){
        //         // do nothing
        //         return false;
        //     }else{
        //         return true;
        //     }
        // });
        // // dd($histories);
        // return response()->json([
        //     'status' => 'success',
        //     'msg' => 'Order timeline view',
        //     'data' => [
        //         'timeline' => $completeHistory,
        //         'histories' => $histories,
        //     ]
        // ]);
    }

    public function divisions()
    {
        return response()->json([
            'status' => 'success',
            'msg' => 'Divisions Fetched',
            'data' => Division::get()
        ]);
    }

    public function cities($division_id)
    {
        return response()->json([
            'status' => 'success',
            'msg' => 'Cities Fetched',
            'data' => City::where('division_id',$division_id)->get()
        ]);
    }

    public function areas($city_id)
    {
        return response()->json([
            'status' => 'success',
            'msg' => 'Areas Fetched',
            'data' => PostCode::where('city_id',$city_id)->get()
        ]);
    }

    private function notify($order)
    {
        try {
            $this->sendSMS($order->billing_address->mobile, "আপনার #" . $order->no . " অর্ডারটি পর্যালোচনার জন্য অপেক্ষায়মান রয়েছে।");
        } catch (\Exception $e) {
            Log::channel('system-info-log')->info($e->getMessage());
        }

        // notify stake holders
        try{
            $notifyReceivers = DeliveredNotifyReceiver::where('status',true)->get();
            $categories = $order->items->pluck('product.category.name');
            $sizes = $order->items->pluck('product.unit.name');
            $sms = "#".$order->no."\nDate:".$order->created_at->format('d.m.y')."\nItems:".implode(',',$categories->all())."\nQty:".implode(',',$sizes->all())."\nTotal:".$order->total;
            if ($notifyReceivers != null){
                foreach ($notifyReceivers as $receiver){
                    $this->sendSMSNonMask($receiver->mobile,$sms);
                }
            }
        }catch(Exception $e){
            Log::channel('system-info-log')->info($e->getMessage());
        }

        try {
            Mail::to($order->billing_address->email)->send(new OrderGenerated($order, $order->billing_address->name,$order->items));
        } catch (\Exception $e) {
            Log::channel('system-info-log')->info($e->getMessage());
        }
    }

    public function getRedeems()
    {
        $point = UserPoint::where('user_id',auth('api')->id())->firstOrFail();
        $redeems = PointRedeem::where('user_id',auth('api')->id())->latest()->get();
        return response()->json([
            'status' => 'success',
            'msg' => 'Order timeline view',
            'data' => [
                'point' => $point->amount,
                'redeems' => $redeems
            ]
        ]);
    }

    public function setRedeem(Request $request)
    {
        $this->validate($request,[
            'point' => 'required|numeric'
        ]);
        $userId = auth('api')->id();
        $point = UserPoint::where('user_id',auth('api')->id())->firstOrFail();
        if($request->point <= $point->amount){
            try{
                DB::beginTransaction();
                $config = SiteConfig::first();
                // generate transaction
                PointTransaction::create([
                    'user_id' => $userId,
                    'amount' => $request->point,
                    'previous_amount' => $point->amount,
                    'status' => 'approved',
                    'type' => 'point-redeem',
                    'note' => null
                ]);
                // substract points from user point
                $point->amount -= $request->point;
                $point->update();
                // create redeem
                PointRedeem::create([
                    'user_id' => $userId,
                    'code' => "rdm-".RedeemController::generateRandomString(6),
                    'valid_till' => now()->addDays(30),
                    'value' => floor($request->point / $config->point_unit),
                    'status' => 'Pending',
                ]);
                DB::commit();
            }catch(Exception $e){
                DB::rollBack();
                return response()->json(["error" => $e->getMessage()]);
            }
            
        }else{
            return response()->json([
                'status' => 'error',
                'msg' => 'Amount is not Valid',
                'data' => ['point' => 'Amount is Not Valid']
            ]);
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'Redeem Generated Successfully.',
            'data' => []
        ]);
    }
}
