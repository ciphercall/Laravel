<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreRequest;
use App\Http\Requests\Cart\DestroyRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Variant;
use App\Traits\CalculateCart;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class CartController extends Controller
{
    use CalculateCart;
    private $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    public function index()
    {
//         $cart = $this->calculateCart();
//         session()->put('cart', $cart);
//         if (!$cart)
//             return redirect()->to('/');
// //        return view('frontend.pages.cart');
        return $this->agent->isMobile() ? view('mobile.pages.new-cart') : view('frontend.pages.new-cart');

    }

    public function show(Request $request)
    {
        $item = session('cart')->cart_items->where('id', az_unhash($request->item))->first();

        return view('frontend.iframe.cartmodal', compact('item'));
    } 

    public function storeAjax(StoreRequest $request)
    {
        $variant = $this->getVariant($request->item, $request->color, $request->size);
        // dd($request->all(),$variant);
        if($variant->item->max_orderable_qty >= $request->qty){
            if ($variant) {
                $cart = Cart::whereAuthUser()->first();
                if (!$cart)
                    $cart = Cart::create(['user_id' => auth('web')->id()]);
    
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
                            'status' => false,
                            'msg' => "Maximum Orderable Limit Crossing."
                            ]);
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
    
                session()->put('cart', $this->calculateCart());
    
                return response()->json([
                    'status' => true,
                    'count' => session()->get('cart')->cart_items->count(),
                    'item' => az_hash($cartItem->id),
                ]);
            }
        }
        
        return response()->json([
            'status' => false,
            'msg' => "Maximum Orderable Limit Crossing."
        ]);
    }

    public function updateAjax(Request $request)
    {
        
        $cItemId = az_unhash($request->cart_item);
        $item = CartItem::find($cItemId);
        
        if($item->product->max_orderable_qty >= $request->qty){
            $item->update([
                'qty' => $request->qty
            ]);

            $cart = $this->calculateCart();
            $cartItem = $cart->cart_items->where('id', $cItemId)->first();
            session()->put('cart', $cart);
    
            return response()->json([
                'status' => true,
                'qty' => $cartItem->qty,
                'sale_subtotal' => $cartItem->sale_subtotal,
                'original_subtotal' => $cartItem->original_subtotal,
                'sale_percentage' => $cartItem->sale_percentage,
                'activeCount' => $cart->activeCount,
                'subtotalWithoutCoupon' => $cart->subtotal_without_coupon + $cart->vat,
                'coupon' => $cart->coupon,
                'couponDiscount' => $cart->coupon_value,
                'subtotal' => $cart->subtotal,
                'deliveryCharge' => $cart->delivery_charge,
                'vat' => $cart->vat,
                'total' => $cart->total,
                'is_coupon_applied' => $cart->is_coupon_applied,

            ]);
        }else{
            return response()->json([
                'status' => false,
                'msg' => "Maximum Order Limit Reached."
            ]);
        }
            
        
    }

    public function updateStatusAjax(Request $request)
    {
        $cartItems = session()->get('cart')->cart_items;
        foreach ($request->cart_items ?? [] as $key => $cItemId) {
            $cItemId = az_unhash($cItemId);
            CartItem::where('id', $cItemId)
                ->update([
                    'active' => $request->actives[$key] == 'true'
                ]);
            $cartItem = $cartItems->where('id', $cItemId)->first();
            $cartItem->active = $request->actives[$key] == 'true';
        }
        $cart = $this->calculateCart();
        session()->put('cart', $cart);

        $prices = [];
        foreach (collect($cart->cart_items->where('active', true)) as $item)
        {
            $prices[] = [
                'item' => az_hash($item->id),
                'sale_subtotal' => $item->sale_subtotal,
                'sale_percentage' => $item->sale_percentage,
                'original_subtotal' => $item->original_subtotal
            ];
        }

        return response()->json([
            'status' => true,
            'activeCount' => $cart->activeCount,
            'subtotalWithoutCoupon' => $cart->subtotal_without_coupon + $cart->vat,
            'coupon' => $cart->coupon,
            'couponDiscount' => $cart->coupon_value,
            'subtotal' => $cart->subtotal,
            'deliveryCharge' => $cart->delivery_charge,
            'vat' => $cart->vat,
            'total' => $cart->total,
            'prices' => $prices,
            'is_coupon_applied' => $cart->is_coupon_applied,
        ]);
    }

    public function applyCouponAjax(Request $request)
    {
        Cart::where('id', session()->get('cart')->id)->update([
            'coupon' => $request->coupon
        ]);
        $cart = $this->calculateCart(false, null, null, $request->coupon);
        session()->put('cart', $cart);

        return response()->json([
            'status' => true,
            'activeCount' => $cart->activeCount,
            'subtotalWithoutCoupon' => $cart->subtotal_without_coupon + $cart->vat,
            'coupon' => $cart->coupon,
            'couponDiscount' => $cart->coupon_value,
            'subtotal' => $cart->subtotal,
            'deliveryCharge' => $cart->delivery_charge,
            'vat' => $cart->vat,
            'total' => $cart->total,
            'is_coupon_applied' => $cart->is_coupon_applied,
        ]);
    }

    public function destroyAjax(Request $request)
    {
        $cItemIds = [];
        foreach ($request->cart_items ?? [] as $cItemId) {
            $cItemIds[] = az_unhash($cItemId);
        }

        CartItem::whereIn('id', $cItemIds)->delete();
        
        $cartItems = session()->get('cart')->cart_items->reject(function ($cItem) use ($cItemIds) {
            return in_array($cItem->id, $cItemIds);
        });
        
        if(count($cartItems) > 0){
            $cart = $this->calculateCart(false, null, $cartItems);
            session()->put('cart', $cart);

            return response()->json([
                'status' => true,
                'count' => $cartItems->count(),
                'activeCount' => $cart->activeCount,
                'subtotalWithoutCoupon' => $cart->subtotal_without_coupon + $cart->vat,
                'coupon' => $cart->coupon,
                'couponDiscount' => $cart->coupon_value,
                'subtotal' => $cart->subtotal,
                'deliveryCharge' => $cart->delivery_charge,
                'vat' => $cart->vat,
                'total' => $cart->total,
                'is_coupon_applied' => $cart->is_coupon_applied,
            ]);
        }else{
            $this->emptyCart();
            return response()->json([
                'status' => true,
                'count' => 0,
                'activeCount' => 0,
                'subtotalWithoutCoupon' => 0,
                'coupon' => null,
                'couponDiscount' => 0,
                'subtotal' => 0,
                'deliveryCharge' => 0,
                'vat' => 0,
                'total' => 0,
            ]);
        }

        
    }

    public function clear()
    {
        Cart::whereAuthUser()->delete();
        session()->forget('cart');

        return response()->json(['status' => true]);
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
