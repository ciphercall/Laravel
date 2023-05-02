<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/cart', 'middleware' => ['auth:web']], function () {
    Route::get('/', 'CartController@index')->name('frontend.cart.index');
    Route::get('/mobile', 'CartController@index')->name('mobile.pages.cart');
    Route::get('/show', 'CartController@show')->name('frontend.cart.show');

    Route::post('/store', 'CartController@storeAjax')->name('frontend.cart.store.ajax');
    Route::post('/update', 'CartController@updateAjax')->name('frontend.cart.update.ajax');
    Route::post('/update-status', 'CartController@updateStatusAjax')->name('frontend.cart.update-status.ajax');
    Route::post('/destroy', 'CartController@destroyAjax')->name('frontend.cart.destroy.ajax');
    Route::post('/apply-coupon', 'CartController@applyCouponAjax')->name('frontend.cart.apply-coupon.ajax');
    Route::post('/clear', 'CartController@clear')->name('frontend.cart.clear');
});

Route::group(['prefix' => '/checkout', 'middleware' => ['auth:web']], function () {
    Route::get('/', 'CheckoutController@index')->name('frontend.checkout.index');
    Route::post('/buy-now', 'CheckoutController@index')->name('frontend.checkout.buy-now');
    Route::post('/', 'CheckoutController@store')->name('frontend.checkout.post');
    Route::post('/pay_online', 'CheckoutController@payOnline')->name('frontend.checkout.pay_online');
    Route::post('/pay_partial', 'CheckoutController@payPartial')->name('frontend.checkout.pay_partial');
    Route::post('/cash_on_delivery', 'CheckoutController@cashOnDelivery')->name('frontend.checkout.cash_on_delivery');
    Route::post('/success', 'CheckoutController@success')->name('frontend.gateway.success');
    Route::post('/fail', 'CheckoutController@fail')->name('frontend.gateway.fail');
    Route::post('/cancel', 'CheckoutController@cancel')->name('frontend.gateway.cancel');
    Route::post('/ipn','CheckoutController@ipn')->name('frontend.gateway.ipn');
    Route::get('/cities', 'CheckoutController@citiesAjax')->name('frontend.checkout.cities.ajax');
    Route::get('/areas', 'CheckoutController@areasAjax')->name('frontend.checkout.areas.ajax');
});
