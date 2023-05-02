<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'orders'], function () {
    // new
    Route::get('/new', 'OrderController@new')->name('delivery.orders.new-index');
    Route::get('/show-new/{no}', 'OrderController@showNew')->name('delivery.orders.new-show');
    Route::get('/accept/{no}', 'OrderController@accept')->name('delivery.orders.accept');

    // on delivery
    Route::get('/on-delivery', 'OrderController@onDelivery')->name('delivery.orders.on-delivery-index');
    Route::get('/show-on-delivery/{no}', 'OrderController@showOnDelivery')->name('delivery.orders.on-delivery-show');
    Route::get('/delivery-success/{no}', 'OrderController@deliverySuccess')->name('delivery.orders.delivery-success');
    Route::get('/delivery-error/{no}', 'OrderController@deliveryError')->name('delivery.orders.delivery-error');

    // delivered
    Route::get('/delivered', 'OrderController@delivered')->name('delivery.orders.delivered-index');
    Route::get('/show-delivered/{no}', 'OrderController@showDelivered')->name('delivery.orders.delivered-show');

    // not delivered
    Route::get('/not-delivered', 'OrderController@notDelivered')->name('delivery.orders.not-delivered-index');
    Route::get('/show-not-delivered/{no}', 'OrderController@showNotDelivered')->name('delivery.orders.not-delivered-show');

    // ajax
    Route::get('/cities/{division}', 'OrderController@citiesAjax')->name('delivery.cities.ajax');
    Route::get('/areas/{city}', 'OrderController@areasAjax')->name('delivery.areas.ajax');
});
