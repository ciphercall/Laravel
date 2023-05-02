<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Wishlist;
use App\Traits\CalculateWishlist;
use Jenssegers\Agent\Agent;
use function MongoDB\BSON\toJSON;

class WishlistController extends Controller
{
    use CalculateWishlist;

    private $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    public function store($slug)
    {
        $item = Item::firstWhere('slug', $slug, ['id']);
        $data['user_id'] = auth('web')->id();
        $data['item_id'] = $item->id;
        $status = false;
        $wish = Wishlist::where('user_id', auth('web')->id())->where('item_id', $item->id)->first();
        if (!$wish) {
            Wishlist::create($data);
            $status = true;
        }
        $this->CalculateWishlist();

        return response()->json(['status' => $status, 'wishcount' => session()->get('wish.count')]);

    }

    public function store_no_auth($slug)
    {
        $item = Item::firstWhere('slug', $slug);

        return response()->json($item);

    }

    public function remove($slug)
    {
        $item = Item::firstWhere('slug', $slug, ['id']);
        $wish = Wishlist::where('user_id', auth('web')->id())->where('item_id', $item->id)->first();

        if ($wish) {
            $wish->delete();
            $this->CalculateWishlist();
            return response()->json(['wishcount' => session()->get('wish.count')]);
        }
        return response()->json(['error deleting item', 400]);
    }

    public function index()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())->with('items')->paginate(20);
//        return view('frontend.pages.wishlist',compact('wishlists'));
        return $this->agent->isMobile() ? view('mobile.pages.wishlist', compact('wishlists')) : view('frontend.pages.wishlist', compact('wishlists'));

    }
//    public function indexMobile()
//    {
//        $wishlists = Wishlist::where('user_id',auth()->id())->with('items')->paginate(20);
//        return view('mobile.pages.wishlist',compact('wishlists'));
//    }

    public function destroy($id)
    {
        Wishlist::find($id)->delete();
        $this->CalculateWishlist();
        notify()->success('Product Deleted successfully.');
        return back();
    }

}
