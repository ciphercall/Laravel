<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\SubCategory;
use App\Seller;

class LoadingMoreProductController extends Controller
{
    public function loadMoreProducts(Request $request)
    {
        $piecesOfData = 12;
        if ($request->has('type')) {

            switch ($request->type) {
                case 'collection':
                    if ($request->has('slug')) {
                        $collection = Collection::where('slug',$request->slug)->first();
                        $products = Item::where('status', true)
                            ->with('variants.color', 'variants.size')
                            ->with(['flash_sales' => function ($q) {
                                $q->whereCurrentDateTime();
                            }])
                            ->where('collection_id', $collection->id)
                            ->inRandomOrder()
                            ->take($piecesOfData)
                            ->get();
                    }else{
                        return response()->json(['error'=>'Slug not Found'], 400);
                    }
                    break;
                case 'seller':
                    if ($request->has('slug')) {
                        $seller = Seller::where('slug',$request->slug)->first();
                        $products = Item::where('status', true)
                        ->with('variants.color', 'variants.size')
                        ->with(['flash_sales' => function ($q) {
                            $q->whereCurrentDateTime();
                        }])
                        ->where('seller_id', $seller->id)
                        ->inRandomOrder()
                        ->take($piecesOfData)
                        ->get();
                    }else{
                        return response()->json(['error'=>'Slug not Found'], 400);
                    }
                    break;
                case 'category':
                    if ($request->has('slug')) {
                        $category = Category::where('slug', $request->slug)->first();
                        $products = Item::where('status', true)
                            ->with('variants.color', 'variants.size')
                            ->with(['flash_sales' => function ($q) {
                                $q->whereCurrentDateTime();
                            }])
                            ->where('category_id', $category->id)
                            ->inRandomOrder()
                            ->take($piecesOfData)
                            ->get();
                    } else {
                        return response()->json(['error' => 'Slug not Found'], 400);
                    }
                    break;
                case 'subCategory':
                    if ($request->has('slug')) {
                        $subCategory = SubCategory::where('slug', $request->slug)->first();
                        $products = Item::where('status', true)
                            ->with('variants.color', 'variants.size')
                            ->with(['flash_sales' => function ($q) {
                                $q->whereCurrentDateTime();
                            }])
                            ->where('sub_category_id', $subCategory->id)
                            ->inRandomOrder()
                            ->take($piecesOfData)
                            ->get();
                    } else {
                        return response()->json(['error' => 'Slug not Found'], 400);
                    }
                    break;
                case 'childCategory':
                    if ($request->has('slug')) {
                        $childCategory = ChildCategory::where('slug', $request->slug)->first();
                        $products = Item::where('status', true)
                            ->with('variants.color', 'variants.size')
                            ->with(['flash_sales' => function ($q) {
                                $q->whereCurrentDateTime();
                            }])
                            ->where('child_category_id', $childCategory->id)
                            ->inRandomOrder()
                            ->take($piecesOfData)
                            ->get();
                    } else {
                        return response()->json(['error' => 'Slug not Found'], 400);
                    }
                    break;
                case 'digital_sheba':
                    $products = Item::where('status', true)
                        ->with('variants.color', 'variants.size')
                        ->with(['flash_sales' => function ($q) {
                            $q->whereCurrentDateTime();
                        }])
                        ->where('digital_sheba', true)
                        ->inRandomOrder()
                        ->take($piecesOfData)
                        ->get();
                    break;
                case 'anaz-mall' :
                    $products = Item::where('status', true)
                        ->with('variants','variants.color','variants.size', 'flash_sales')
                        ->whereHasPremiumSeller()
                        ->inRandomOrder()
                        ->take($piecesOfData)
                        ->get();
                    break;
                case 'discounts':
                    $products = Item::where('status', true)
                        ->with('variants.color', 'variants.size')
                        ->with(['flash_sales' => function ($q) {
                            $q->whereCurrentDateTime();
                        }])
                        ->whereHasDiscounts()
                        ->inRandomOrder()
                        ->take($piecesOfData)
                        ->get();
                    break;
                case 'best_seller':
                    $products = Item::where('status', true)
                        ->with('variants.color', 'variants.size')
                        ->with(['flash_sales' => function ($q) {
                            $q->whereCurrentDateTime();
                        }])
                        ->where('best_seller', true)
                        ->inRandomOrder()
                        ->take($piecesOfData)
                        ->get();
                    break;
                case 'flash_sale':
                    $products = Item::where('status', true)
                        ->with([
                            'flash_sales' => function ($q) {
                                $q->select('id', 'item_id', 'start_time', 'end_time', 'percentage')->whereCurrentDateTime();
                            },
                            'variants' => function ($q) {
                                $q->select('id', 'item_id', 'price', 'qty', 'sale_price', 'sale_start_day', 'sale_end_day');
                            }
                        ])
                        ->whereHas('flash_sales', function ($q) {
                            $q->whereCurrentDateTime();
                        })
                        ->inRandomOrder()
                        ->limit(6)
                        ->get();
                    break;
                default:
                        $products = Item::where('status', true)
                        ->with('variants','variants.color','variants.size', 'flash_sales')
                        ->inRandomOrder()
                        ->take($piecesOfData)
                        ->get();
                    break;
            }
        }else {
            $products = Item::where('status', true)
                ->with('variants','variants.color','variants.size', 'flash_sales')
                ->inRandomOrder()
                ->take($piecesOfData)
                ->get();
        }

        $products->map(function ($product) {
            $product['priceAttached'] = $product->original_price;
            $product['salePercentageAttached'] = $product->sale_percentage;
            $product['salePriceAttached'] = $product->sale_price;
        });
        return response()->json($products, 200);
    }
}
