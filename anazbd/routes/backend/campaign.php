<?php

use Illuminate\Support\Facades\Route;

// flash sale
Route::group(['prefix' => 'flash-sales','middleware' => 'can:manage_flash_sale_old_panel'], function () {
    Route::get('/', 'FlashSaleController@index')->name('backend.campaign.flash_sale.index');
    Route::get('/create', 'FlashSaleController@create')->name('backend.campaign.flash_sale.create');
    Route::get('/edit/{id}', 'FlashSaleController@edit')->name('backend.campaign.flash_sale.edit');

    Route::post('/store', 'FlashSaleController@store')->name('backend.campaign.flash_sale.store');
    Route::post('/update/{id}', 'FlashSaleController@update')->name('backend.campaign.flash_sale.update');
    Route::get('/delete/{id}', 'FlashSaleController@destroy')->name('backend.campaign.flash_sale.destroy');
});

// Coupons
Route::group(['prefix' => 'coupons'], function () {
    Route::get('/', 'CouponController@index')
        ->name('backend.campaign.coupons.index');
    Route::get('/create', 'CouponController@create')
        ->name('backend.campaign.coupons.create');
    Route::get('/edit/{coupon}', 'CouponController@edit')
        ->name('backend.campaign.coupons.edit');

    // non view
    Route::get('/destroy/{id}', 'CouponController@destroy')
        ->name('backend.campaign.coupons.destroy');
    Route::post('/store', 'CouponController@store')
        ->name('backend.campaign.coupons.store');
    Route::post('/update/{coupon}', 'CouponController@update')
        ->name('backend.campaign.coupons.update');
});
