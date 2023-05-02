<?php

use Illuminate\Support\Facades\Route;

// flash sale
Route::group(['prefix' => 'flash-sales'], function () {
    Route::get('/', 'FlashSaleController@index')->name('seller.campaign.flash_sale.index');
    Route::get('/create', 'FlashSaleController@create')->name('seller.campaign.flash_sale.create');
    Route::get('/edit/{start_time}', 'FlashSaleController@edit')->name('seller.campaign.flash_sale.edit');

    Route::post('/store', 'FlashSaleController@store')->name('seller.campaign.flash_sale.store');
    Route::post('/update/{start_time}', 'FlashSaleController@update')->name('seller.campaign.flash_sale.update');
    Route::get('/delete/{id}', 'FlashSaleController@destroy')->name('seller.campaign.flash_sale.destroy');

    Route::get('/count/{date}/{time}', 'FlashSaleController@ajaxCount')->name('seller.campaign.flash_sale.count');
});
