<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Question;
use App\Models\QuickPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function show($slug)
    {
        // dd(Item::with('variants')->get()->filter(function($item){
        //     return $item->variants->count() > 2;
        // }));
        $product = Item::with('seller:id,slug,shop_name','warranty_type:id,name')->withCount('comments')->where('slug',$slug)->where('status',true)->first();
        $product->load('variants','variants.size:id,name','variants.color:id,name');
        $mainImage = url('/')."/".$product->feature_image;
        $images = $product->other_images->implode('path',',');

        $totalRating = Comment::where('item_id',$product->id)->sum('rating');

        return response()->json([
            'status'  => 'success',
            'message' => 'Single Item Fetched with rating',
            'data'    => [
                'products' => $product,
                'questions' => Question::where('item_id',$product->id)->with('answer','user:id,name')->latest()->simplePaginate(10),
                'rating' => $product->comments_count > 0 ? $totalRating / $product->comments_count : $product->rating,
                'images' => $product->feature_image.",".$images,
                'return_policy' => QuickPage::where('slug','return-policy')->select('short_desc')->first()->short_desc,
                'warranty_policy' => QuickPage::where('slug','warranty-policy')->select( 'short_desc')->first()->short_desc,
            ]
        ]);
    }

    public function reviews($slug)
    {
        $item = Item::where('slug',$slug)->where('status',true)->first();
        $reviews = Comment::where('item_id',$item->id)->with('user:id,name')->paginate(15);

        return response()->json([
            'status'  => 'success',
            'message' => '40 Items fetched',
            'data'    => [
                'reviews' => $reviews
            ]
        ]);
    }
}
