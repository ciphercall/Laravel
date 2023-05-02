<?php

use Illuminate\Support\Facades\Route;

//items
Route::group(['prefix' => 'product','middleware'=>'can:view_products'],function (){
    
    Route::group(['middleware'=>'can:export_products'], function() {
        Route::get('/items/exportable','ItemController@export')->name('admin.product.item.export');
        Route::post('/items/import','ItemController@import')->name('admin.product.item.import');
    });
    Route::get('/{id}/history', 'ItemController@history')->name('admin.product.history')->middleware('can:view_product_history');
    Route::get('/items','ItemController@index')->name('admin.product.item.index');
    Route::put('/items/{item}','ItemController@status')->name('admin.product.item.status');
    Route::delete('/items/{item}/delete','ItemController@destory')->name('admin.product.item.destroy');
    Route::put('/items/{id}/restore','ItemController@restore')->name('admin.product.item.restore');
    Route::put('/items/{item}/delivery-type','ItemController@changeDeliveryType')->name('admin.product.item.deliveryType');
});





























?>
