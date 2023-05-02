<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function getShopProducts($slug)
    {
        $seller = Seller::where('slug',$slug)->with('profile:id,seller_id,product_image')->select('id','shop_name')->first();
        $items = Item::where('status',true)->whereSellerSlug($slug)->latest()->paginate(20);
        return response()->json([
            'status'  => 'success',
            'message' => "Items of $slug Loaded",
            'data'    => $items,
            'seller' => $seller
        ]);
    }
}
