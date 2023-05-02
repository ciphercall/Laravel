<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Color;
use App\Models\Item;
use App\Models\SubCategory;
use App\Models\WarrantyType;
use App\Seller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Collection;

class SellerController extends Controller
{

    private $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    public function index(Request $request)
    {
        $sellers = Seller::with('profile')
            ->whereHas('items', function ($q) {
                $q->where('status', true);
            })
            ->where('status',true)
            ->where('is_premium',true)
            ->orderBy('premium_order')
            ->paginate(12);


            $sellers_mobile = Seller::with('profile')
            ->whereHas('items', function ($q) {
                $q->where('status', true);
            })
            ->where('status',true)
            ->where('is_premium',true)
            ->orderBy('premium_order')
            ->get();


        if ($this->agent->isDesktop()) {
            return view('frontend.pages.allshops', compact('sellers'));
        } else {
            return view('mobile.pages.shops', compact('sellers_mobile'));
        }

    }

    public function anazmallSeller()
    {
        $sellers_mobile = Seller::with('profile')
        ->whereHas('items', function ($q) {
            $q->where('status', true);
        })
        ->where('is_anazmall_seller',true)
        ->where('status',true)
        ->orderBy('anazmall_order')
        ->get();


        $sellers = Seller::with('profile')
            ->whereHas('items', function ($q) {
                $q->where('status', true);
            })
            ->where('is_anazmall_seller',true)
            ->where('status',true)
            ->orderBy('anazmall_order')
            ->paginate(12);

        if ($this->agent->isDesktop()) {
            return view('frontend.pages.allshops', compact('sellers'));
        } else {
            return view('mobile.pages.shops', compact('sellers_mobile'));
        }
    }
    public function ajaxLoadMore(Request $request)
    {
        $shopType = $request->shopType;
        if ($shopType == 'anazMallShops'){
            $sellers = Seller::with('profile')
                ->whereHas('items', function ($q) {
                    $q->where('status', true);
                })
                ->where('status',true)
                ->where('is_anazmall_seller',true)
                ->orderBy('anazmall_order')
                ->paginate(12, ['*'], 'page', $request->page);

            $sellers = collect(collect($sellers)['data'])->map(function ($s) {
                $s['image'] = asset($s['profile']['logo']);
                $s['shop_image'] = asset($s['profile']['product_image']);

                unset($s['items']);
                return $s;
            });

            return response()->json($sellers);
        }elseif($shopType == 'premium'){
            $sellers = Seller::with('profile')
            ->whereHas('items', function ($q) {
                $q->where('status', true);
            })
            ->where('status',true)
            ->where('is_premium',true)
            ->orderBy('premium_order')
            ->paginate(12, ['*'], 'page', $request->page);

        $sellers = collect(collect($sellers)['data'])->map(function ($s) {
            $s['image'] = asset($s['profile']['logo']);
            $s['shop_image'] = asset($s['profile']['product_image']);

            unset($s['items']);
            return $s;
        });

        return response()->json($sellers);
        }else{
            $sellers = Seller::with('profile')
                ->whereHas('items', function ($q) {
                    $q->where('status', true);
                })
                ->where('status',true)
                ->orderBy('premium_order')
                ->paginate(12, ['*'], 'page', $request->page);

            $sellers = collect(collect($sellers)['data'])->map(function ($s) {
                $s['image'] = asset($s['profile']['logo']);
                $s['shop_image'] = asset($s['profile']['product_image']);

                unset($s['items']);
                return $s;
            });

            return response()->json($sellers);
        }


    }

    public function show(Request $request, $slug)
    {
        $seller = Seller::with('profile')->where('slug', $slug)->first();

        if (!$seller || !$seller->status) {
            return back();
        }

        // Filter
        $items = Item::where('status', true)
            ->with('variants.color', 'variants.size')
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
            ->where('seller_id', $seller->id)
            ->when($request->category, function ($q) use ($request) {
                $q->whereCategorySlug($request->category);
            })
            ->when($request->sub_category, function ($q) use ($request) {
                $q->whereSubCategorySlug($request->sub_category);
            })
            ->when($request->child_category, function ($q) use ($request) {
                $q->whereChildCategorySlug($request->child_category);
            })
            ->when($request->brand, function ($q) use ($request) {
                $q->whereBrandSlug($request->brand);
            })
            ->when($request->color, function ($q) use ($request) {
                $q->whereColorName($request->color);
            })
            ->when($request->min || $request->max, function ($q) use ($request) {
                $q->wherePrice($request->min, $request->max);
            })
            ->when($request->asc, function ($q) use ($request) {
                $q->customOrderBy($request->asc, 'asc');
            })
            ->when($request->desc, function ($q) use ($request) {
                $q->customOrderBy($request->desc, 'desc');
            })
            ->latest()
            ->take(12)
            ->get();

        // Radio Buttons
        $categories = Category::whereHas('items', function ($q) use ($seller) {
            $q->where('seller_id', $seller->id);
        })->get(['slug', 'name']);

        if ($request->category)
            $sub_categories = SubCategory::whereHas('items', function ($q) use ($seller, $request) {
                $q->where('seller_id', $seller->id)
                    ->whereHas('category', function ($r) use ($request) {
                        $r->where('slug', $request->category);
                    });
            })->get(['slug', 'name']);
        else $sub_categories = collect([]);

        if ($request->sub_category)
            $child_categories = ChildCategory::whereHas('items', function ($q) use ($seller, $request) {
                $q->where('seller_id', $seller->id)
                    ->whereHas('sub_category', function ($r) use ($request) {
                        $r->where('slug', $request->sub_category);
                    });
            })->get(['slug', 'name']);
        else $child_categories = collect([]);

        $brands = Brand::whereHas('items', function ($q) use ($seller) {
            $q->where('seller_id', $seller->id);
        })->get(['slug', 'name']);

        $colors = Color::whereHas('variants.item', function ($q) use ($seller) {
            $q->where('seller_id', $seller->id);
        })->get(['name']);

        $warranty_types = WarrantyType::whereHas('items', function ($q) use ($seller) {
            $q->where('seller_id', $seller->id);
        })->get(['name']);

        if ($this->agent->isDesktop()) {
            return view('frontend.pages.shopproducts', compact('items', 'seller', 'categories', 'sub_categories', 'child_categories', 'brands', 'colors', 'warranty_types'));
        } else {
            return view('mobile.pages.shopproducts', compact('items', 'seller', 'categories', 'sub_categories', 'child_categories', 'brands', 'colors', 'warranty_types'));
        }

    }
    public function loadMore($slug)
    {
        $seller = Seller::where('slug', $slug)->first();

        if (!$seller) {
            return back();
        }
        $items = Item::where('status', true)
        ->with('variants.color', 'variants.size')
        ->with(['flash_sales' => function ($q) {
            $q->whereCurrentDateTime();
        }])
            ->where('seller_id', $seller->id)
            ->inRandomOrder()
            ->take(12)
            ->get();

        return response()->json($items, 200);
    }
}
