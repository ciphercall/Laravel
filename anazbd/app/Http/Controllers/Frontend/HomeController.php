<?php

namespace App\Http\Controllers\Frontend;

use App\Admin\Blog;
use App\CashReturn;
use App\Http\Controllers\Controller;
use App\Models\BillingAddress;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\City;
use App\Models\Collection;
use App\Models\Color;
use App\Models\DeliveryAddress;
use App\Models\Division;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PostCode;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Models\Variant;
use App\Models\WarrantyType;
use App\SearchHistory;
use App\Seller;
use App\User;
use App\UserPoint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    private $agent,$date;

    public function __construct()
    {
        $this->agent = new Agent();
        $this->date = Carbon::now()->addDay();
    }

    public function index()
    {
        $flash_sale_items = $this->getFlashSaleItems();

        // most discounted products

        $discountedVariants = Variant::orderByRaw('((price - sale_price) / price) * 100 desc')->take(20)->get(['id','item_id'])->pluck('item_id');
        $discounted = Item::with('variants')->whereIn('id',$discountedVariants)->take(20)->get();

        $recommanded = null;
        if(auth('web')->check()){
            $orders = Order::where('user_id',auth('web')->id())->get(['id']);
            if($orders->count() > 0){
                $orderItems = OrderItem::whereIn('order_id',$orders)->get(['id','item_id']);
                $tags = Tag::whereHas('items', function($q) use($orderItems){
                    $q->whereIn('item_id',$orderItems->pluck('item_id'));
                })->get('id')->pluck('id');
                $recommanded = Item::with('tags:tag_id','variants')->whereNotIn('id',$orderItems->pluck('item_id'))->whereHas('tags',function($q)use ($tags){
                    $q->whereIn('tag_id',$tags);
                })->inRandomOrder()->take(20)->get()->sortByDesc(function($item) use ($tags){
                    return $item->tags->pluck('tag_id')->intersect($tags)->count();
                })
                ->take(20);
            }
        }
        // $categories = null;
        $categories = cache()->remember('home_category',$this->date,function(){
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

        $collections = cache()->remember('home_collection',$this->date,function(){
            return Collection::has('items')->withCount('items')
            ->with(['items' => function($q){
                // $q->select('id','slug','feature_image');
                $q->latest()->take(30);
            }])
            // ->with('items')
            ->where('status', true)->where('show_in_home', true)->get();
        });


        $premium_sellers = cache()->remember('spotlight_seller',$this->date,function(){
            return Seller::has('items')
            ->where('status',true)
            ->where('is_premium', true)
            ->with(['random_items','profile'])
            ->orderBy('premium_order')
            ->get(['id', 'shop_name', 'image', 'slug']);
        });

        $anazmall_sellers = cache()->remember('empire_seller',$this->date,function(){
            return Seller::has('items')
            ->where('status',true)
            ->where('is_anazmall_seller', true)
            ->with(['random_items','profile'])
            ->orderBy('anazmall_order')
            ->get(['id', 'shop_name', 'image', 'slug']);
        });
        // dd($premium_sellers,$anazmall_sellers);

        $just_for_you = Item::where('status', true)
            ->with('variants', 'flash_sales')
            ->inRandomOrder()
            ->take(18)
            ->get();

        $compacted = compact('categories', 'premium_sellers', 'anazmall_sellers', 'flash_sale_items', 'just_for_you', 'collections','discounted', 'recommanded');
        return $this->agent->isMobile() ? view('mobile.index', $compacted) : view('welcome', $compacted);
    }

    function anazEmpireUniqueAjax(){
        $anazmall_sellers = cache()->remember('empire_seller',$this->date,function(){
            return Seller::has('items')
                ->where('status',true)
                ->where('is_anazmall_seller', true)
                ->with(['random_items','profile'])
                ->orderBy('anazmall_order')
                ->get(['id', 'shop_name', 'image', 'slug']);
        });
        return response()->json($anazmall_sellers);
    }

    public function categories()
    {
        $categories = cache()->remember('all_categories',$this->date,function(){
            return Category::has('items')
            ->where('show_on_top', true)
            ->take(16)
            ->get(['id', 'name', 'slug', 'image']);
        });

        return view('frontend.pages.allCategories',compact('categories'));
    }

    public function showCategories()
    {
        $categories = Category::where('show_on_top', true)
//            ->take(16)
            ->get(['id', 'name', 'slug', 'image']);

//        return view('frontend.pages.allCategories',compact('categories'));
        return $this->agent->isMobile() ? view('mobile.pages.categories', compact('categories')) : view('frontend.pages.categories', compact('categories'));
    }

    public function recipes()
    {
        $posts = Blog::with('admin')->where('title', 'LIKE', '%' . "রেসিপি" . '%')->latest()->paginate(20);
        $recent_posts = Blog::latest()->limit(10)->get();
        return $this->agent->isMobile() ? view('mobile.pages.recipes', compact('posts','recent_posts')) : view('frontend.pages.recipes', compact('posts','recent_posts'));

    }

    public function mobile()
    {
        return view('frontend.mobile.index');
    }

    public function justforyou()
    {
        $just_for_you = Item::where('status', true)
            ->with('variants', 'flash_sales')
            ->inRandomOrder()
            ->take(18)
            ->get();
        return $this->agent->isMobile() ? view('mobile.pages.justforyou', compact('just_for_you')) : view('welcome', compact('just_for_you'));
    }

    public function mobileWishlist()
    {
        return view('mobile.pages.wishlist');
    }

    public function mobileBlog()
    {
        return view('mobile.pages.blog');
    }

    public function blog($value = '')
    {
        return view('frontend.pages.blog');
    }

    public function contactus($value = '')
    {
        return view('frontend.pages.contactus');
    }

    public function aboutus($value = '')
    {
        return view('frontend.pages.aboutus');
    }

    public function ajaxFlashSaleItems(Request $request)
    {
        return response()->json([
            'items' => $this->getFlashSaleItems()
        ]);
    }


    public function mobileShops()
    {
        return view('mobile.pages.shops');
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

    public function searchAutocomplete(Request $request)
    {
        // dd($request->all());
        $query = $request->search;
        // $items = Item::where('status', true)
        //     ->where('name', 'LIKE', '%' . $query . '%')
        //     ->orwhereHas('tags', function ($q) use ($query) {
        //         $q->where('name', 'LIKE', '%' . $query . '%');
        //     })
        //     ->orwhereHas('variants', function ($q) use ($query) {
        //         $q->where('sku', 'LIKE', '%' . $query . '%');
        //     })
        //     ->orwhereHas('origin', function ($q) use ($query) {
        //         $q->where('name', 'LIKE', '%' . $query . '%');
        //     })
        //     ->orwhereHas('brand', function ($q) use ($query) {
        //         $q->where('name', 'LIKE', '%' . $query . '%');
        //     })
        //     ->orwhereHas('category', function ($q) use ($query) {
        //         $q->where('name', 'LIKE', '%' . $query . '%');
        //     })
        //     ->orwhereHas('sub_category', function ($q) use ($query) {
        //         $q->where('name', 'LIKE', '%' . $query . '%');
        //     })
        //     ->orwhereHas('child_category', function ($q) use ($query) {
        //         $q->where('name', 'LIKE', '%' . $query . '%');
        //     })
        //     ->limit(10)
        //     ->get();

        // if ($items) {
        //     return response()->json($items,200);
        // }
        $tags = Tag::whereHas('items')->where('name', 'LIKE', $query . '%')->limit(10)->get();
        if($tags){
            return response()->json($tags,200);
        }
        return response()->json(['error','Somethings not right.'],400);

    }

    public function search(Request $request)
    {
        $query = $request->search;
        SearchHistory::create([
           'user_id' => auth()->check() ? auth()->id() : null,
            'search' => $query
        ]);

        $items = Item::where('status', true)
            ->where('name', 'LIKE', '%' . $query . '%')
            ->with('variants', 'flash_sales')
            ->orwhereHas('tags', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->orwhereHas('variants', function ($q) use ($query) {
                $q->where('sku', 'LIKE', '%' . $query . '%');
            })
            ->orwhereHas('origin', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->orwhereHas('brand', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->orwhereHas('category', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->orwhereHas('sub_category', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->orwhereHas('child_category', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->paginate(18);
            if(request()->ajax()){
                return response()->json($items);
            }
        if ($items) {
            if ($this->agent->isDesktop()) {
                return view('frontend.pages.search', compact('items', 'query'));
            } else {
                return view('mobile.pages.search', compact('items', 'query'));
            }
        } else {
            notify()->error("No Items Found. Try again later.");
            return back();
        }
    }

    public function account()
    {
        $orders = Order::with(['items','items.product'])->where('user_id', auth('web')->id())->orderByDesc('order_time')->get();
        $divisions = Division::orderBy('id')->get(['id', 'name']);
        $cities = City::where('division_id', auth('web')->user()->division_id)->get(['id', 'name']);
        $areas = PostCode::where('city_id', auth('web')->user()->city_id)->get(['id', 'name']);
        $billing_address = BillingAddress::where('user_id',auth('web')->id())->latest()->first();
        $delivery_address = DeliveryAddress::where('user_id',auth('web')->id())->latest()->first();
        $cashBack = auth('web')->user()->cash_return;
        $points = UserPoint::firstOrCreate([
            'user_id' => auth('web')->id(),
        ],[
            'amount' => 0,
            'active' => 1
        ]);
//        return view('frontend.pages.myaccount', compact('orders', 'divisions', 'cities', 'areas'));
        return $this->agent->isMobile() ? view('mobile.pages.myaccount', compact('points', 'orders', 'divisions', 'cities', 'areas','billing_address','delivery_address','cashBack')) : view('frontend.pages.myaccount', compact('points','orders', 'divisions', 'cities', 'areas','billing_address','delivery_address','cashBack'));

    }

    public function OrderDetails($id)
    {
        $order = Order::whereAuthUser()->with(['details', 'items','items.seller', 'histories','user_coupon'])->findOrFail($id);
        // $record = Order::whereAuthUser()->with(['details', 'items','items.seller', 'histories','user_coupon:name,coupon_on,value'])->findOrFail($id);
        // $order = [];
        // foreach($record->items as $item){
        //     if($item->seller->is_anazmall_seller){
        //         $key = "Anaz Empire";
        //     }else if($item->seller->is_premium){
        //         $key = "Anaz Spotlight";
        //     }else{
        //         $key = "Other Sellers";
        //     }
        //     $order[$key][$item->seller->shop_name][] = $item;
        // }
        // $order["subtotal"] = $record->subtotal;
        // $order["total"] = $record->total;
        // $order["delivery_charge"] = $record->shipping_charge;
        // $order["coupon"] = $record->user_coupon->name ?? null;
        // $order["coupon_value"] = $record->user_coupon->value ?? null;
        // dd($record,$order);
        return $this->agent->isMobile() ? view('mobile.pages.OrderDetails', compact('order')) : view('frontend.pages.OrderDetails', compact('order'));

    }

    public function accountSave(Request $request)
    {
        $user = User::where('id', auth('web')->id())->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'division_id' => az_unhash($request->division),
            'city_id' => az_unhash($request->city),
            'post_code_id' => az_unhash($request->area),
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
        ]);
        return back();
    }

    public function orderview($id)
    {
        $order = Order::with('details', 'items', 'histories')->findOrFail($id);
//        return view('frontend.pages.orderview', compact('order'));
        return $this->agent->isMobile() ? view('mobile.pages.orderview', compact('order')) : view('frontend.pages.orderview', compact('order'));

    }

    public function globalCollection()
    {
        $collections = Collection::has('items')->withCount('items')->where('status', true)->paginate(12);
        return $this->agent->isMobile() ? view('mobile.pages.collections', compact('collections')) : view('frontend.pages.globalcollection', compact('collections'));

    }

    public function ajaxCollectionLoadMore(Request $request)
    {
        $collections = Collection::has('items')
            ->withCount('items')
            ->where('status', true)
            ->orderBy('show_in_home')
            ->paginate(12, ['*'], 'page', $request->page);

        $sellers = collect(collect($collections)['data'])->map(function ($c) {
            $c['url'] = route('frontend.collection', $c['slug']);
            $c['cover_photo'] = asset($c['cover_photo']);
            $c['cover_photo_2'] = asset($c['cover_photo_2']);
            $c['cover_photo_3'] = asset($c['cover_photo_3']);
            return $c;
        });

        return response()->json($sellers);
    }

    public function forgetPassword($var = null)
    {
//        return view('frontend.pages.foragetPassword');
        return $this->agent->isMobile() ? view('mobile.pages.forgetPassword') : view('frontend.pages.foragetPassword');

    }

    public function forgetPasswordsave(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'otp' => 'required',
            'password' => 'min:8|confirmed'
        ]);
        $username = $request->username;
        $otp = $request->otp;

        $user = User::where(function ($query) use ($username, $otp) {
            $query->where('email', '=', $username)
                ->orWhere('mobile', '=', $username)
                ->Where('status', '=', true)
                ->where('otp', '=', $otp);
        })->first(['id', 'email', 'mobile']);
        try {
            $user->update([
                'otp' => null,
                'password' => Hash::make($request->password),
            ]);

        } catch (\Exception $e) {

            notify()->success('sorry! something is wrong.');
            return back();
        }
        notify()->success('Password updated successfully.');
        return redirect('/');
    }
    public function getBrands(){
        $brands = Brand::select('name','image')->get();
        return response()->json($brands);
    }
}
