<?php

namespace App\Http\Controllers\API;

use App\Admin\Blog;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\QuickPage;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\Variant;
use App\Models\Wishlist;
use App\Seller;
use App\Traits\CalculateCart;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use CalculateCart;

    public function index(){
    $date = Carbon::now()->addDay();
    $flash_sale_items = $this->getFlashSaleItems();

    $discountedVariants = Variant::orderByRaw('((price - sale_price) / price) * 100 desc')->take(20)->get(['id','item_id'])->pluck('item_id');
    $discounted = Item::whereIn('id',$discountedVariants)->where('status',true)->take(20)->get();

    $recommanded = null;
    if(auth('api')->check()){
        $orders = Order::where('user_id',auth('api')->id())->get(['id']);
        if($orders->count() > 0){
            $orderItems = OrderItem::whereIn('order_id',$orders)->get(['id','item_id']);
            $tags = Tag::whereHas('items', function($q) use($orderItems){
                $q->whereIn('item_id',$orderItems->pluck('item_id'));
            })->get('id')->pluck('id');
            $recommanded = Item::with('tags:tag_id')->where('status',true)->whereNotIn('id',$orderItems->pluck('item_id'))->whereHas('tags',function($q)use ($tags){
                $q->whereIn('tag_id',$tags);
            })->inRandomOrder()->take(20)->get()->sortByDesc(function($item) use ($tags){
                return $item->tags->pluck('tag_id')->intersect($tags)->count();
            })
            ->take(20);
        }
    }
    
    // $banner = Banner::where('status',true)->first();
    // $sliders = Slider::orderBy('position')->where('status', true)->get();
    
    // $categories = Category::with([
    //         'sub_categories' => function ($q) {
    //             $q->with(['child_categories' => function ($r) {
    //                 $r->select('subcategory_id', 'name', 'slug');
    //             }])->select( 'category_id', 'name', 'slug','delivery_charge');
    //         }
    //     ])
    //     ->where('show_on_top', true)
    //     ->take(16)
    //     ->get([ 'name', 'slug', 'image']);

    // $collections = Collection::has('items')->withCount('items')->where('status', true)->where('show_in_home', true)->get(['title','slug','cover_photo','items_count']);

    // $premium_sellers = Seller::has('items')
    // ->where('status',true)
    // ->where('slug','!=','ctg-vape-shop')
    // ->where('is_premium', true)
    // ->with(['profile'])
    // ->orderBy('premium_order')
    // ->get(['id', 'shop_name', 'image', 'slug']);

    // $anazmall_sellers = Seller::has('items')
    // ->where('status',true)
    // ->where('is_anazmall_seller', true)
    // ->with(['profile'])
    // ->orderBy('anazmall_order')
    // ->get(['id', 'shop_name', 'image', 'slug']);
    // $categories = null;

    $sliders = cache()->remember('sliders',$date,function(){
        return Slider::orderBy('position')->where('status', true)->get(['image','slug']);
    });
    $banner = cache()->remember('banner',$date,function(){
        return Banner::where('status',true)->first();
    });
    
    $categories = cache()->remember('home_category',$date,function(){
        return Category::with([
            'sub_categories' => function ($q) {
                $q->with(['child_categories' => function ($r) {
                    $r->select('id', 'subcategory_id', 'name', 'slug');
                }])->select('id', 'category_id', 'name', 'slug');
            }
        ])
        ->where('show_on_top', true)
        ->take(16)
        ->get(['id', 'name', 'slug', 'image']);
    });

    $collections = cache()->remember('home_collection',$date,function(){
        return Collection::has('items')->withCount('items')
        ->with(['items' => function($q){
            // $q->select('id','slug','feature_image');
            $q->latest()->take(30);
        }])
        // ->with('items')
        ->where('status', true)->where('show_in_home', true)->get();
    });


    $premium_sellers = cache()->remember('spotlight_seller',$date,function(){
        return Seller::has('items')
        ->where('status',true)
        ->where('is_premium', true)
        ->with(['random_items','profile'])
        ->orderBy('premium_order')
        ->get(['id', 'shop_name', 'image', 'slug']);
    });

    $anazmall_sellers = cache()->remember('empire_seller',$date,function(){
        return Seller::has('items')
        ->where('status',true)
        ->where('is_anazmall_seller', true)
        ->with(['random_items','profile'])
        ->orderBy('anazmall_order')
        ->get(['id', 'shop_name', 'image', 'slug']);
    });
    if(auth('api')->id() != null){
        // $cart = $this->calculateCartAPI();
        $wishlists = Wishlist::where('user_id',auth('api')->id())->count();
        $cart = Cart::where('user_id',auth('api')->id())->first();
        $cartCount = CartItem::where('cart_id',$cart->id)->count();
    }else{
        $cartCount = 0;
        $wishlists = 0;
    }

    // $just_for_you = Item::where('status', true)
    //     ->with('variants', 'flash_sales')
    //     ->where('seller_id','!=',37)
    //     ->inRandomOrder()
    //     ->take(40)
    //     ->get();

    return response()->json([
        'status'  => 'success',
        'message' => 'Slider, Banner, Flash Sale Items, Categories, Collections, Premium sellers, Anaz Sellers, Items',
        'data'    => [
            'sliders' => $sliders,
            'banner' => $banner,
            'flash_sale_items' => $flash_sale_items,
            'categories' => $categories,
            'collection' => $collections,
            'premium_sellers' => $premium_sellers,
            'anaz_sellers' => $anazmall_sellers,
            'cart_count' => $cartCount,
            'wishlist_count' => $wishlists ?? 0,
            'products' => [],
            'recommanded' => $recommanded,
            'discounted' => $discounted
        ]
    ]);
    }

    public function homeProducts()
    {
        $items = Item::where('status', true)
        ->with('variants', 'flash_sales')
        ->where('seller_id','!=',37)
        ->inRandomOrder()
        ->take(40)
        ->get();

        return response()->json([
            'status'  => 'success',
            'message' => '40 Items fetched',
            'data'    => [
                'products' => $items
            ]
        ]);
    }
    public function getDigitalSheba()
    {
        $items = Item::where('digital_sheba',true)->where('status',true)->latest()->paginate(20);
        return response()->json([
            'status'  => 'success',
            'message' => 'Digital sheba Loaded',
            'data'    => $items
        ]);
    }

    public function recipes()
    {
        $posts = Blog::where('title', 'LIKE', '%' . "রেসিপি" . '%')->latest()->paginate(20);
        return response()->json([
            'status'  => 'success',
            'message' => 'Anaz Recipes Loaded',
            'data'    => $posts
        ]);
    }

    public function getRecipe($slug)
    {
        $post = Blog::where('slug',$slug)->first();
        return response()->json([
            'status'  => 'success',
            'message' => "$slug loaded",
            'data'    => $post
        ]);
    }

    public function getDiscounts()
    {
        $items = Item::where('status', true)
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
            ->whereHasDiscounts()
            ->latest()
            ->paginate(20);
            return response()->json([
                'status'  => 'success',
                'message' => 'Discounts Loaded',
                'data'    => $items
            ]);
    }

    public function getCollections()
    {
        $collections = Collection::has('items')->withCount('items')->where('status', true)->paginate(20);
        return response()->json([
            'status'  => 'success',
            'message' => 'Collections Loaded',
            'data'    => $collections
        ]);
    }

    public function getEmpire()
    {
        $items = Item::where('status', true)
            ->whereHasAnazSeller()
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
            ->latest()
            ->paginate(20);
        return response()->json([
            'status'  => 'success',
            'message' => 'Anaz Empire Loaded',
            'data'    => $items
        ]);
    }

    public function getSpotlight()
    {
        $items = Item::where('status', true)
            ->whereHasPremiumSeller()
            ->where('slug','!=','ctg-vape-shop')
            ->with(['flash_sales' => function ($q) {
                $q->whereCurrentDateTime();
            }])
            ->latest()
            ->paginate(20);
        return response()->json([
            'status'  => 'success',
            'message' => 'Anaz Spotlight Loaded',
            'data'    => $items
        ]);
    }

    private function getFlashSaleItems()
    {
        $items = Item::where('status', true)
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

        $sales = collect([]);

        foreach ($items as $item) {
            $o = new \stdClass();
            $o->name = $item->name;
            $o->url = route('frontend.product', $item->slug);
            $o->image = asset($item->feature_image);
            $o->end_time = collect($item->flash_sales)->first()->end_time->format('Y-m-d H:i:s');
            $o->original_price = $item->original_price;
            $o->sale_percentage = $item->sale_percentage;
            $o->sale_price = $item->sale_price;
            $o->isWishlisted = $item->isWishlisted;
            $o->slug = $item->slug;
            $sales->push($o);
        }

        return $sales;
    }

    public function privacyPolicy()
    {
        $policy = QuickPage::where('slug','privacy-policy')->firstOrFail();

        return response()->json([
            'status' => 'success',
            'msg' => 'Privacy Policy Fetched',
            'data' => $policy
        ]);
    }

    public function termsAndConditions()
    {
        $policy = QuickPage::where('slug','terms-and-conditions')->firstOrFail();

        return response()->json([
            'status' => 'success',
            'msg' => 'terms-and-conditions Fetched',
            'data' => $policy
        ]);
    }

    
}
