<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::with(['user','cart_items','cart_items.product' => function($q){
            $q->withTrashed();
        }])
        ->when($request->name,function ($q) use($request){
            $q->whereHas('user',function ($r) use ($request){
                $r->where('name', 'LIKE', '%' . $request->name . '%');
            });
        })
        ->when($request->mobile,function ($q) use($request){
            $q->whereHas('user',function ($r) use ($request){
                $r->where('mobile',$request->mobile);
            });
        })
        ->when($request->mobile,function ($q) use($request){
            $q->whereHas('user',function ($r) use ($request){
                $r->where('email',$request->email);
            });
        })
        ->when($request->item,function ($q) use($request){
            $q->whereHas('cart_items',function ($r) use ($request){
                $r->whereHas('product',function ($s) use ($request){
                    $s->where('name', 'LIKE', '%' . $request->item . '%');
                });
            });
        })
        ->paginate(20)->appends([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'item' => $request->item,
        ]);
        // $cartItems = CartItem::with('cart','cart.user')->latest();

        $isAdmin = session()->get('isAdmin');
        if ($isAdmin){
            return view('admin.cart.index',compact('cart'));
        }
        return view('backend.cart.index',compact('cart'));
    }
}
