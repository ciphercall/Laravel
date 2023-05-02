<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/orders'], function () {
    Route::get('/pending', 'OrderController@pending')->name('seller.order.pending.index');
    Route::get('/pending/show/{id}', 'OrderController@showPending')->name('seller.order.pending.show');

    Route::get('/on-delivery', 'OrderController@onDelivery')->name('seller.order.on-delivery.index');
    Route::get('/on-delivery/show/{id}', 'OrderController@showOnDelivery')->name('seller.order.on-delivery.show');

    Route::get('/delivered', 'OrderController@delivered')->name('seller.order.delivered.index');
    Route::get('/delivered/show/{id}', 'OrderController@showDelivered')->name('seller.order.delivered.show');

    Route::get('/cancelled', 'OrderController@cancelled')->name('seller.order.cancelled.index');
    Route::get('/cancelled/show/{id}', 'OrderController@showCancelled')->name('seller.order.cancelled.show');
});
