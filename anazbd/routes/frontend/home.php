<?php

use Illuminate\Support\Facades\Route;
use App\Models\Order;


// Not Authenticated
Route::group(['prefix' => '/'], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/mytestct', function ()
    {
        $order = Order::with('items','items.product:id,name','billing_address','user_coupon')->where('no','ANC-V3XY1E')->first();
        dd($order);
        // return view('mail.order-cancelled', ['order_no' => $this->order_no, 'name' => $this->name, 'summary' =>$order]);
    });


    Route::get('/account', 'HomeController@account')->name('user.myaccount');
    Route::get('/blog', 'HomeController@blog');
    Route::get('/contactus', 'HomeController@contactus');
    Route::get('/aboutus', 'HomeController@aboutus');
    Route::get('/empireajax', 'HomeController@anazEmpireUniqueAjax')-> name('frontend.home.empireajax');

    Route::group(['prefix'=>'upload-and-order'],function (){
        Route::get('/','SelfOrderController@index')->name('frontend.self.order.index');
        Route::post('/','SelfOrderController@store')->name('frontend.self.order.store');
        Route::post('/image/{id}','SelfOrderController@image')->name('frontend.self.order.image');
    });
    //ajax
    Route::get('/getShortDesc/{slug}', 'QuickPageController@quickPageSD')->name('ajax.getShortDesc');

    //mobile
    Route::get('/mobileWishlist', 'HomeController@mobileWishlist')->name('mobile.wishlist');
    Route::get('/mobileBlog', 'HomeController@mobileBlog')->name('mobile.blog');
//    Route::get('/mobileShops', 'HomeController@mobileShops')->name('mobile.shops');
    //mobile

    //career

    Route::group(['prefix' => 'jobs'], function() {
        Route::get('/','CareerController@index')->name('frontend.career');
        Route::get('/apply/form/{slug?}','CareerController@apply')->name('frontend.career.apply');
        Route::post('/apply','CareerController@store')->name('frontend.career.store');
    });

    // Loading more products
    Route::post('/more/products/','LoadingMoreProductController@loadMoreProducts')->name('load.products');

    Route::get('/categories','HomeController@categories')->name('categories.all');
    Route::get('/show-categories','HomeController@showCategories')->name('categories.show');

    Route::get('/product/{slug}', 'ProductController@product')->name('frontend.product');
    Route::get('/category/{slug}', 'ProductController@category')->name('frontend.category');
    Route::get('/sub-category/{slug}', 'ProductController@sub_category')->name('frontend.sub_category');
    Route::get('/child-category/{slug}', 'ProductController@child_category')->name('frontend.child_category');
    Route::get('/flash-sales', 'ProductController@flash_sale')->name('frontend.flash_sale');
    Route::get('/ajax/flash-sale', 'HomeController@ajaxFlashSaleItems')->name('frontend.flash_sale.ajax');
    Route::get('/best-sellers', 'ProductController@best_seller')->name('frontend.best_seller');
    Route::get('/digital-sheba', 'ProductController@digital_sheba')->name('frontend.digital_sheba');
    Route::get('/discounts', 'ProductController@discounts')->name('frontend.discounts');
    Route::get('/anaz-empire', 'ProductController@anaz_mall')->name('frontend.anaz_mall');
    Route::get('/recipes', 'HomeController@recipes')->name('frontend.recipes');
    Route::get('/just-for-you', 'HomeController@justforyou')->name('frontend.justforyou');

    Route::get('/checkout', 'HomeController@checkout');

    // search autocomplete
    Route::post('/search/autocomplete','HomeController@searchAutocomplete')->name('search.autocomplete');
    Route::get('/search', 'HomeController@search')->name('search');

    Route::post('/tracing-order', 'TrackController@tracking')->name('tracking');

    Route::get('/account', 'HomeController@account')->name('account');
    Route::get('/order/{id}/details', 'HomeController@OrderDetails')->name('order.details');
    Route::get('/order-view/{id}', 'HomeController@orderview')->name('order.view');
    Route::post('/account/update','HomeController@accountSave')->name('user.account.save');

    Route::get('/points','RedeemController@index')->name('user.account.point');
    Route::post('/points/redeem','RedeemController@redeemPoint')->name('user.account.point.redeem');

    Route::get('/forget/Password', "HomeController@forgetPassword")->name('user.forget.password');
    Route::post('/forget/Password', "HomeController@forgetPasswordsave")->name('user.forget.password.save');
});

Route::get('/global-collection/','HomeController@globalCollection')->name('frontend.global_collections');
Route::post('/global-collection/load-more', 'HomeController@ajaxCollectionLoadMore')->name('frontend.global_collections.load-more.ajax');
Route::get('/collections/{slug}', 'ProductController@showCollection')->name('frontend.collection');

Route::group(['prefix' => '/shops'], function () {
    Route::get('/', 'SellerController@index')->name('frontend.seller.shop.index');
    Route::get('/anaz-empire-sellers','SellerController@anazmallSeller')->name('frontend.anazmall-seller.shops');
    Route::get('/{slug}', 'SellerController@show')->name('frontend.seller.shop.show');
    Route::post('/load-more', 'SellerController@ajaxLoadMore')->name('frontend.seller.shop.load-more.ajax');
});

Route::get('/brands/','HomeController@getBrands')->name('frontend.get-brands');

