<?php

namespace App\Traits;

use App\Models\Wishlist;

trait CalculateWishlist
{
    private function CalculateWishlist( )
    {
        $wishlist = WishList::where('user_id',auth('web')->id())->get();
        session()->put('wish.count', $wishlist->count());
    }
}
