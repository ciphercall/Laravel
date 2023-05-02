<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BillingAddress;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\City;
use App\Models\Collection;
use App\Models\Color;
use App\Models\DeliverySize;
use App\Models\Division;
use App\Models\Item;
use App\Models\PostCode;
use App\Models\SubCategory;
use App\Models\Comment;
use App\Models\Question;
use App\Models\WarrantyType;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class ProductController extends Controller
{

    private $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    public function api_products()
    {
        $item = Item::where('status', true)
        ->with('variants')
        ->inRandomOrder()
        ->take(40)
        ->get();
        return response()->json([
            'status'  => 'success',
            'message' => '40 items Fetched successfully',
            'data'    => $item
        ],200);
    }
    public function product($slug)
    {
        $item = Item::where('status', true)
            ->with('variants.color', 'variants.size', 'brand', 'feature_image', 'other_images', 'comments', 'delivery_size', 'warranty_type')
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
            ->with(['questions' => function($q){
                $q->where('approved',true);
            }])
            ->where('slug', $slug)
            ->where('status', true)
            ->first();
        if (!$item)
            return redirect()->to('/');
        
        foreach ($item->variants ?? [] as $v) {
            $v['sale_percentage'] = $item->getSalePercentageAttribute($v);
            $v['sale_price'] = $item->getSalePriceAttribute($v);
        }
        
        $comments = Comment::status()->where('item_id', $item->id ?? -1)->get();
        $res = $this->getDeliveryCharge($item->delivery_size);
        $delivery_charge = $res['charge'];
        $location = $res['location'];

        if(auth('web')->check()){
            $questionsByUser = Question::where('user_id',auth('web')->user()->id)->where('item_id',$item->id)->where('approved',false)->get();
        }else{
            $questionsByUser = null;
        }
        $related_items = Item::where('sub_category_id',$item->sub_category_id)
            ->where(function ($query) use ($item) {
                $query->where('id', '<>', $item->id)
                    ->where('status', true)
                    ->select('id', 'name', 'slug', 'feature_image', 'status');
            })
            ->paginate(12);
        if ($this->agent->isDesktop()) {
            return view('frontend.pages.product', compact('item','questionsByUser', 'comments', 'delivery_charge', 'location', 'related_items'));
        } else {
            return view('mobile.pages.product', compact('item', 'comments', 'related_items','questionsByUser'));
        }
    }

    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();

        // Filter
        $items = Item::where('status', true)
            ->with('variants.color', 'variants.size')
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
            ->where('category_id', $category->id)
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
            ->paginate(12);

        // Radio Buttons
        $brands = Brand::whereHas('items', function ($q) use ($category) {
            $q->where('category_id', $category->id)->where('status', true);
        })->get(['slug', 'name']);

        $colors = Color::whereHas('variants.item', function ($q) use ($category) {
            $q->where('category_id', $category->id)->where('status', true);
        })->get(['name']);

        $warranty_types = WarrantyType::whereHas('items', function ($q) use ($category) {
            $q->where('category_id', $category->id)->where('status', true);
        })->get(['name']);

        $sub_categories = SubCategory::whereHas('items', function ($q) use ($category) {
            $q->where('category_id', $category->id)->where('status', true);
        })->get(['slug', 'name']);

        $child_categories = collect([]);
        if ($request->sub_category)
            $child_categories = ChildCategory::whereHas('items', function ($q) use ($request) {
                $q->where('status', true)
                    ->whereHas('sub_category', function ($r) use ($request) {
                        $r->where('slug', $request->sub_category);
                    });
            })->get(['slug', 'name']);

        if ($this->agent->isDesktop()) {
            return view('frontend.pages.allcategory', compact('category', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));
        } else {
            return view('mobile.pages.allcategory', compact('category', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));
        }
    }

    public function sub_category(Request $request, $slug)
    {
        $sub_category = SubCategory::with('category')->where('slug', $slug)->first();

        // Filter
        $items = Item::where('status', true)
            ->with('variants.color', 'variants.size')
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
            ->where('sub_category_id', $sub_category->id)
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
            ->paginate(12);

        // Radio Buttons
        $brands = Brand::whereHas('items', function ($q) use ($sub_category) {
            $q->where('sub_category_id', $sub_category->id)->where('status', true);
        })->get(['slug', 'name']);

        $colors = Color::whereHas('variants.item', function ($q) use ($sub_category) {
            $q->where('sub_category_id', $sub_category->id)->where('status', true);
        })->get(['name']);

        $warranty_types = WarrantyType::whereHas('items', function ($q) use ($sub_category) {
            $q->where('sub_category_id', $sub_category->id)->where('status', true);
        })->get(['name']);

        $child_categories = ChildCategory::whereHas('items', function ($q) use ($sub_category) {
            $q->where('sub_category_id', $sub_category->id)->where('status', true);
        })->get(['slug', 'name']);

        if ($this->agent->isDesktop()) {
            return view('frontend.pages.subcategory', compact('sub_category', 'items', 'child_categories', 'brands', 'colors', 'warranty_types'));
        } else {
            return view('mobile.pages.subcategory', compact('sub_category', 'items', 'child_categories', 'brands', 'colors', 'warranty_types'));
        }
    }

    public function child_category(Request $request, $slug)
    {
        $child_category = ChildCategory::with('category', 'sub_category')->where('slug', $slug)->first();

        // Filter
        $items = Item::where('status', true)
            ->with('variants.color', 'variants.size')
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
            ->where('child_category_id', $child_category->id)
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
            ->paginate(12);

        // Radio Buttons
        $brands = Brand::whereHas('items', function ($q) use ($child_category) {
            $q->where('child_category_id', $child_category->id)->where('status', true);
        })->get(['slug', 'name']);

        $colors = Color::whereHas('variants.item', function ($q) use ($child_category) {
            $q->where('child_category_id', $child_category->id)->where('status', true);
        })->get(['name']);

        $warranty_types = WarrantyType::whereHas('items', function ($q) use ($child_category) {
            $q->where('child_category_id', $child_category->id)->where('status', true);
        })->get(['name']);

        return view('frontend.pages.childcategory', compact('child_category', 'items', 'brands', 'colors', 'warranty_types'));
    }

    public function showCollection(Request $request, $slug)
    {
        $collection = Collection::where('slug', $slug)->first();

        // Filter
        $items = Item::where('status', true)
            ->with('variants.color', 'variants.size')
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
            ->where('collection_id', $collection->id)
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
            ->paginate(12);

        // Radio Buttons
        $brands = Brand::whereHas('items', function ($q) use ($collection) {
            $q->where('collection_id', $collection->id)->where('status', true);
        })->get(['slug', 'name']);

        $colors = Color::whereHas('variants.item', function ($q) use ($collection) {
            $q->where('collection_id', $collection->id)->where('status', true);
        })->get(['name']);

        $warranty_types = WarrantyType::whereHas('items', function ($q) use ($collection) {
            $q->where('collection_id', $collection->id)->where('status', true);
        })->get(['name']);

        $categories = Category::whereHas('items', function ($q) use ($request, $collection) {
            $q->where('collection_id', $collection->id)->where('status', true);
        })->get(['slug', 'name']);

        $sub_categories = collect([]);
        if ($request->category)
            $sub_categories = SubCategory::whereHas('items', function ($q) use ($request, $collection) {
                $q->where('collection_id', $collection->id)->where('status', true)
                    ->whereHas('sub_category', function ($r) use ($request) {
                        $r->where('slug', $request->sub_category);
                    });
            })->get(['slug', 'name']);

        $child_categories = collect([]);
        if ($request->sub_category)
            $child_categories = ChildCategory::whereHas('items', function ($q) use ($request, $collection) {
                $q->where('collection_id', $collection->id)->where('status', true)
                    ->whereHas('child_category', function ($r) use ($request) {
                        $r->where('slug', $request->child_category);
                    });
            })->get(['slug', 'name']);

//        return view('frontend.pages.collection', compact('collection', 'categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));
        return $this->agent->isMobile() ? view('mobile.pages.collection', compact('collection','categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types')) : view('frontend.pages.collection', compact('collection','categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));

    }

    public function flash_sale(Request $request)
    {
        // Filter
        $items = Item::where('status', true)
            ->with('variants.color', 'variants.size')
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
            ->whereHas('flash_sales', function ($q) {
                $q->whereCurrentDateTime();
            })
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
            ->paginate(12);

        // Radio Buttons
        $brands = Brand::whereHas('items', function ($q) {
            $q->whereHasActiveFlashSales();
        })->get(['slug', 'name']);

        $colors = Color::whereHas('variants.item', function ($q) {
            $q->whereHasActiveFlashSales();
        })->get(['name']);

        $warranty_types = WarrantyType::whereHas('items', function ($q) {
            $q->whereHasActiveFlashSales();
        })->get(['name']);

        $categories = Category::whereHas('items', function ($q) use ($request) {
            $q->whereHasActiveFlashSales();
        })->get(['slug', 'name']);

        $sub_categories = collect([]);
        if ($request->category)
            $sub_categories = SubCategory::whereHas('items', function ($q) use ($request) {
                $q->whereHasActiveFlashSales()
                    ->whereHas('sub_category', function ($r) use ($request) {
                        $r->where('slug', $request->sub_category);
                    });
            })->get(['slug', 'name']);

        $child_categories = collect([]);
        if ($request->sub_category)
            $child_categories = ChildCategory::whereHas('items', function ($q) use ($request) {
                $q->whereHasActiveFlashSales()
                    ->whereHas('child_category', function ($r) use ($request) {
                        $r->where('slug', $request->child_category);
                    });
            })->get(['slug', 'name']);


//        return view('frontend.pages.flashsale', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));
        return $this->agent->isMobile() ? view('mobile.pages.flashsale', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types')) : view('frontend.pages.flashsale', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));

    }

    public function best_seller(Request $request)
    {
        // Filter
        $items = Item::where('status', true)
            ->where('best_seller', true)
            ->with('variants.color', 'variants.size')
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
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
            ->paginate(12);

        // Radio Buttons
        $brands = Brand::whereHas('items', function ($q) {
            $q->where('best_seller', true)->where('status', true);
        })->get(['slug', 'name']);

        $colors = Color::whereHas('variants.item', function ($q) {
            $q->where('best_seller', true)->where('status', true);
        })->get(['name']);

        $warranty_types = WarrantyType::whereHas('items', function ($q) {
            $q->where('best_seller', true)->where('status', true);
        })->get(['name']);

        $categories = Category::whereHas('items', function ($q) use ($request) {
            $q->where('best_seller', true)->where('status', true);
        })->get(['slug', 'name']);

        $sub_categories = collect([]);
        if ($request->category)
            $sub_categories = SubCategory::whereHas('items', function ($q) use ($request) {
                $q->where('best_seller', true)->where('status', true)
                    ->whereHas('sub_category', function ($r) use ($request) {
                        $r->where('slug', $request->sub_category);
                    });
            })->get(['slug', 'name']);

        $child_categories = collect([]);
        if ($request->sub_category)
            $child_categories = ChildCategory::whereHas('items', function ($q) use ($request) {
                $q->where('best_seller', true)->where('status', true)
                    ->whereHas('child_category', function ($r) use ($request) {
                        $r->where('slug', $request->child_category);
                    });
            })->get(['slug', 'name']);

//        return view('frontend.pages.bestseller', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));
        return $this->agent->isMobile() ? view('mobile.pages.bestseller', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types')) : view('frontend.pages.bestseller', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));
    }

    public function digital_sheba(Request $request)
    {
        // Filter
        $items = Item::where('status', true)
            ->where('digital_sheba', true)
            ->with('variants.color', 'variants.size')
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
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
            ->paginate(12);

        // Radio Buttons
        $brands = Brand::whereHas('items', function ($q) {
            $q->where('digital_sheba', true)->where('status', true);
        })->get(['slug', 'name']);

        $colors = Color::whereHas('variants.item', function ($q) {
            $q->where('digital_sheba', true)->where('status', true);
        })->get(['name']);

        $warranty_types = WarrantyType::whereHas('items', function ($q) {
            $q->where('digital_sheba', true)->where('status', true);
        })->get(['name']);

        $categories = Category::whereHas('items', function ($q) use ($request) {
            $q->where('digital_sheba', true)->where('status', true);
        })->get(['slug', 'name']);

        $sub_categories = collect([]);
        if ($request->category)
            $sub_categories = SubCategory::whereHas('items', function ($q) use ($request) {
                $q->where('digital_sheba', true)->where('status', true)
                    ->whereHas('sub_category', function ($r) use ($request) {
                        $r->where('slug', $request->sub_category);
                    });
            })->get(['slug', 'name']);

        $child_categories = collect([]);
        if ($request->sub_category)
            $child_categories = ChildCategory::whereHas('items', function ($q) use ($request) {
                $q->where('digital_sheba', true)->where('status', true)
                    ->whereHas('child_category', function ($r) use ($request) {
                        $r->where('slug', $request->child_category);
                    });
            })->get(['slug', 'name']);

//        return view('frontend.pages.digitalsheba', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));
        return $this->agent->isMobile() ? view('mobile.pages.digitalsheba', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types')) : view('frontend.pages.digitalsheba', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));

    }

    public function discounts(Request $request)
    {
        // Filter
        $items = Item::where('status', true)
            ->with('variants.color', 'variants.size')
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
            ->whereHasDiscounts()
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
            ->paginate(12);

        // Radio Buttons
        $brands = Brand::whereHas('items', function ($q) {
            $q->whereHasDiscounts()->where('status', true);
        })->get(['slug', 'name']);

        $colors = Color::whereHas('variants.item', function ($q) {
            $q->whereHasDiscounts()->where('status', true);
        })->get(['name']);

        $warranty_types = WarrantyType::whereHas('items', function ($q) {
            $q->whereHasDiscounts()->where('status', true);
        })->get(['name']);

        $categories = Category::whereHas('items', function ($q) use ($request) {
            $q->whereHasDiscounts()->where('status', true);
        })->get(['slug', 'name']);

        $sub_categories = collect([]);
        if ($request->category)
            $sub_categories = SubCategory::whereHas('items', function ($q) use ($request) {
                $q->whereHasDiscounts()->where('status', true)
                    ->whereHas('sub_category', function ($r) use ($request) {
                        $r->where('slug', $request->sub_category);
                    });
            })->get(['slug', 'name']);

        $child_categories = collect([]);
        if ($request->sub_category)
            $child_categories = ChildCategory::whereHas('items', function ($q) use ($request) {
                $q->whereHasDiscounts()->where('status', true)
                    ->whereHas('child_category', function ($r) use ($request) {
                        $r->where('slug', $request->child_category);
                    });
            })->get(['slug', 'name']);

//        return view('frontend.pages.discounts', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));
        return $this->agent->isMobile() ? view('mobile.pages.discounts', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types')) : view('frontend.pages.discounts', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));

    }

    public function anaz_mall(Request $request)
    {
        // Filter
        $items = Item::where('status', true)
            ->whereHasAnazSeller()
            ->with('variants.color', 'variants.size')
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
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
            ->paginate(12);

        // Radio Buttons
        $brands = Brand::whereHas('items', function ($q) {
            $q->whereHasPremiumSeller()->where('status', true);
        })->get(['slug', 'name']);

        $colors = Color::whereHas('variants.item', function ($q) {
            $q->whereHasPremiumSeller()->where('status', true);
        })->get(['name']);

        $warranty_types = WarrantyType::whereHas('items', function ($q) {
            $q->whereHasPremiumSeller()->where('status', true);
        })->get(['name']);

        $categories = Category::whereHas('items', function ($q) use ($request) {
            $q->whereHasPremiumSeller()->where('status', true);
        })->get(['slug', 'name']);

        $sub_categories = collect([]);
        if ($request->category)
            $sub_categories = SubCategory::whereHas('items', function ($q) use ($request) {
                $q->whereHasPremiumSeller()->where('status', true)
                    ->whereHas('sub_category', function ($r) use ($request) {
                        $r->where('slug', $request->sub_category);
                    });
            })->get(['slug', 'name']);

        $child_categories = collect([]);
        if ($request->sub_category)
            $child_categories = ChildCategory::whereHas('items', function ($q) use ($request) {
                $q->whereHasPremiumSeller()->where('status', true)
                    ->whereHas('child_category', function ($r) use ($request) {
                        $r->where('slug', $request->child_category);
                    });
            })->get(['slug', 'name']);

//        return view('frontend.pages.mall', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));
        return $this->agent->isMobile() ? view('mobile.pages.mall', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types')) : view('frontend.pages.mall', compact('categories', 'sub_categories', 'child_categories', 'items', 'brands', 'colors', 'warranty_types'));
    }

    private function getDeliveryCharge(DeliverySize $size)
    {
        $billing_address = BillingAddress::where('user_id', auth('web')->id())->with('division', 'city', 'area')->latest()->first();
        $user = $billing_address == null ? User::with('division', 'city', 'area')->find(auth('web')->id()) : null;
        $res = [];
        if ($billing_address) {
            $res['charge'] = az_is_dhaka($billing_address->city_id) ? $size->customer_dhaka : $size->customer_other;
            $res['location'] = $billing_address->division->name ?? '' . ', ' . $billing_address->city->name ?? '' . ', ' . $billing_address->area->name ?? '';
        } else if ($user) {
            $res['charge'] = az_is_dhaka($user->city_id) ? $size->customer_dhaka : $size->customer_other;
            $res['location'] = $user->division->name ?? ''. ', ' . $user->city->name ?? ''. ', ' . $user->area->name ?? '';
        } else {
            $res['charge'] = $size->customer_dhaka;
            $division = Division::find(1);
            $city = City::where('division_id', $division->id)->first();
            $area = PostCode::where('city_id', $city->id)->first();
            $res['location'] = $division->name ?? ''. ', ' . $city->name ?? ''. ', ' . $area->name ?? '';
        }
        return $res;
    }
}
