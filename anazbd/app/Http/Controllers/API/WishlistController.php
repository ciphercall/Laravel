<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    private function getUser(){
        return request()->user();
    }

    public function index()
    {
        return response()->json([
            'status' => 'success',
            'msg' => 'Wishlist fetched',
            'data' => $this->getItems()
        ]);
    }

    public function store($slug)
    {
        $user = $this->getUser();
        $product = Item::where('slug',$slug)->where('status',true)->first();
        if($product){
            $item = Wishlist::create([
                'user_id' => $user->id,
                'item_id' => $product->id
            ]);
            return response()->json([
                'status' => 'success',
                'msg' => 'Item added in wishlist',
                'data' => []
            ]);        
        }
        return response()->json([
            'status' => 'error',
            'msg' => 'Item adding failed',
            'data' => []
        ],400);
        
    }

    public function destory($id)
    {
        Wishlist::findOrFail($id)->delete();

        return response()->json([
            'status' => 'success',
            'msg' => 'Item deleted in wishlist',
            'data' => $this->getItems()
        ]);   
    }

    private function getItems(){
        $user = $this->getUser();
        return Wishlist::with('items')->where('user_id',$user->id)->latest()->get();
    }

    
}
