<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'orders','middleware' => 'can:manage_orders_old_panel'], function () {
    Route::get('/', 'OrderController@index')->name('backend.order.index');
    Route::post('/update/{id}', 'OrderController@update')->name('backend.order.update');
    Route::get('/destroy/{id}', 'OrderController@pendingDestroy')->name('backend.order.destroy');

    Route::get('/pending', 'OrderController@pending')->name('backend.order.pending.index');
    Route::get('/show-pending/{id}', 'OrderController@showPending')->name('backend.order.pending.show');
    Route::get('/edit-pending/{id}', 'OrderController@editPending')->name('backend.order.pending.edit');
    Route::post('/update-pending/{id}', 'OrderController@updatePending')->name('backend.order.pending.update');

    Route::get('/waiting', 'OrderController@waiting')->name('backend.order.waiting.index');
    Route::get('/show-waiting/{id}', 'OrderController@showWaiting')->name('backend.order.waiting.show');
    Route::get('/edit-waiting/{id}', 'OrderController@editWaiting')->name('backend.order.waiting.edit');
    Route::post('/update-waiting/{id}', 'OrderController@updateWaiting')->name('backend.order.waiting.update');

    Route::get('/on-delivery', 'OrderController@onDelivery')->name('backend.order.on-delivery.index');
    Route::get('/show-on-delivery/{id}', 'OrderController@showOnDelivery')->name('backend.order.on-delivery.show');

    Route::get('/not-delivered', 'OrderController@notDelivered')->name('backend.order.not-delivered.index');
    Route::get('/show-not-delivered/{id}', 'OrderController@showNotDelivered')->name('backend.order.not-delivered.show');
    Route::get('/edit-not-delivered/{id}', 'OrderController@editNotDelivered')->name('backend.order.not-delivered.edit');
    Route::post('/update-not-delivered/{id}', 'OrderController@updateNotDelivered')->name('backend.order.not-delivered.update');

    Route::get('/delivered', 'OrderController@delivered')->name('backend.order.delivered.index');
    Route::get('/show-delivered/{id}', 'OrderController@showDelivered')->name('backend.order.delivered.show');

    Route::get('/cancelled', 'OrderController@cancelled')->name('backend.order.cancelled.index');
    Route::get('/show-cancelled/{id}', 'OrderController@showCancelled')->name('backend.order.cancelled.show');
    Route::get('/edit-cancelled/{id}', 'OrderController@editCancelled')->name('backend.order.cancelled.edit');

    Route::get('/status/pending/{id}/{to}', 'OrderController@makePending')->name('backend.order.status.pending');
    Route::get('/status/accept/{id}/{to}', 'OrderController@makeAccepted')->name('backend.order.status.accept');
    Route::get('/status/cancel/{id}/{to}', 'OrderController@makeCancelled')->name('backend.order.status.cancel');
    Route::get('/status/on-delivery/{id}/{to}', 'OrderController@makeOnDelivery')->name('backend.order.status.on-delivery');
    Route::get('/status/deliver/{id}/{to}', 'OrderController@makeDelivered')->name('backend.order.status.deliver');

    Route::get('/cities/{division_id}', 'OrderController@ajaxCities')->name('backend.order.cities.ajax');
    Route::get('/areas/{city_id}', 'OrderController@ajaxAreas')->name('backend.order.areas.ajax');
    Route::get('/products/{seller_id}', 'OrderController@ajaxProducts')->name('backend.order.products.ajax');
    Route::get('/variants/{seller_id}/{order_id}', 'OrderController@ajaxVariants')->name('backend.order.price.ajax');
});
