<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('user','items')->orderByDesc('id')->paginate(20);

        $isAdmin = session()->get('isAdmin');
        if ($isAdmin){
            return view('admin.wishlist.index',compact('wishlists'));
        }
        return view('backend.wishlist.index',compact('wishlists'));
    }
}
