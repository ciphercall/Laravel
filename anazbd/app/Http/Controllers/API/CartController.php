<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Variant;
use App\Traits\CalculateCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    use CalculateCart;

    public function index()
    {
        $cart = $this->calculateCartAPI();
        if($cart != null){
            return response()->json([
                'status'  => 'success',
                'message' => "Cart Data fetched",
                'data'    => $cart
            ]);
        }
        return response()->json([
            'status'  => 'success',
            'message' => "Cart Data fetched",
            'data'    => [
                'cart_items' => []
            ]
        ]);
    }

    public function couponAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'  => 'error',
                'message' => "Coupon not added.",
                'data'    => $validator->errors()
            ],422);
        }
        
        $user = request()->user();
        Cart::where('user_id',$user->id)->first()->update([
            'coupon' => $request->coupon
        ]);

        $cart = $this->calculateCartAPI();
        return response()->json([
            'status'  => 'success',
            'message' => "Cart Data fetched",
            'data'    => $cart
        ]);
    }

    public function redeemAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'redeem' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'  => 'error',
                'message' => "Redeem not added.",
                'data'    => $validator->errors()
            ],422);
        }
        
        $user = request()->user();
        Cart::where('user_id',$user->id)->first()->update([
            'redeem' => $request->redeem
        ]);

        $cart = $this->calculateCartAPI();
        return response()->json([
            'status'  => 'success',
            'message' => "Cart Data fetched",
            'data'    => $cart
        ]);
    }

    public function create(Request $request)
    {
        $variant = $this->getVariant($request->item, $request->color, $request->size);
        $user = request()->user();
        if ($variant) {
            $cart = Cart::where('user_id',$user->id)->first();
            if (!$cart)
                $cart = Cart::create(['user_id' => $user->id]);

            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('item_id', $variant->item_id)
                ->where('variant_id', $variant->id)
                ->where('seller_id', $variant->item->seller_id)
                ->first();

            if ($cartItem) {
                if(($cartItem->qty + $request->qty) <= $variant->item->max_orderable_qty){
                    $cartItem->qty = $cartItem->qty + $request->qty;
                    $cartItem->save();
                }else{
                    return response()->json([
                        'status' => "error",
                        'msg' => "Maximum Orderable Limit Crossing.",
                        'data' => []
                    ],422);
                }
                
            } else {
                $cartItem = CartItem::create([
                    'cart_id' => $cart->id,
                    'item_id' => $variant->item_id,
                    'variant_id' => $variant->id,
                    'seller_id' => $variant->item->seller_id,
                    'qty' => $request->qty
                ]);
            }

            return response()->json([
                'status' => "success",
                'msg' => "Item Added in Cart Successfully",
                'data' => [],
            ]);
        }
        return response()->json([
            'status' => "error",
            'msg' => "Something Went Wrong",
            'data' => []
        ],422);
    }
    
    
        


    public function increase($id)
    {
        $cartItem = CartItem::find($id);
        if($cartItem->qty < $cartItem->product->max_orderable_qty){
            $cartItem->qty += 1;
            $cartItem->update();

            return response()->json([
                'status'  => 'success',
                'message' => "Cart Item Updated",
                'data'    => $this->calculateCartAPI()
            ]);
        }
        return response()->json([
            'status'  => 'error',
            'message' => "Maximum Orderable Qty Reached",
            'data'    => $this->calculateCartAPI()
        ]);
    }

    public function decrease($id)
    {
        $cartItem = CartItem::find($id);
        if($cartItem->qty > 1){
            $cartItem->qty -= 1;
            $cartItem->update();

            return response()->json([
                'status'  => 'success',
                'message' => "Cart Item Updated",
                'data'    => $this->calculateCartAPI()
            ]);
        }
        return response()->json([
            'status'  => 'error',
            'message' => "Minimum Item Qty Limit reached.",
            'data'    => $this->calculateCartAPI()
        ]);
    }

    public function delete($id)
    {
        CartItem::findOrFail($id)->delete();
        return response()->json([
            'status'  => 'success',
            'message' => "Cart Updated",
            'data'    => $this->calculateCartAPI()
        ]);
    }

    // helper
    private function getVariant($slug, $color, $size)
    {
        $variant = Variant::whereHas('item', function ($q) use ($slug) {
            $q->where('slug', $slug);
        });
        if ($color) {
            $variant->whereHas('color', function ($q) use ($color) {
                $q->where('name', $color);
            });
        }
        if ($size) {
            $variant->whereHas('size', function ($q) use ($size) {
                $q->where('name', $size);
            });
        }
        return $variant->with('item')->first();
    }
}
