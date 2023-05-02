<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'wishlist'], function () {
    Route::get('/', 'WishlistController@index')->name('user.wishlist');
//    Route::get('/mobile', 'WishlistController@indexMobile')->name('user.wishlistMobile');
    Route::get('/{slug}', 'WishlistController@store')->name('store.wishlist');
    Route::get('no_auth/{slug}', 'WishlistController@store_no_auth')->name('no_auth.wishlist');
    Route::get('/remove/{slug}','WishlistController@remove')->name('wishlist.remove');
    Route::get('/destroy/{id}', 'WishlistController@destroy')->name('frontend.wishlist.destory');
});
