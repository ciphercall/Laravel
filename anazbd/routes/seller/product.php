<?php

use Illuminate\Support\Facades\Route;

// Item
Route::group(['prefix' => 'items'], function () {
    Route::get('/', 'ItemController@index')
        ->name('seller.product.items.index');
    Route::get('/create', 'ItemController@create')
        ->name('seller.product.items.create');
    Route::get('/edit/{id}', 'ItemController@edit')
        ->name('seller.product.items.edit');

    // non view
    Route::get('/destroy/{id}', 'ItemController@destroy')
        ->name('seller.product.items.destroy');
    Route::post('/store', 'ItemController@store')
        ->name('seller.product.items.store');
    Route::post('/update/{id}', 'ItemController@update')
        ->name('seller.product.items.update');
    Route::get('/delete/images/{item_id}/{image_id}', 'ItemController@deleteOtherImage')
        ->name('seller.product.items.delete.other-image');

    // ajax
    Route::get('/ajax/sub-categories/{category_id}', 'ItemController@ajaxGetSubCategories')
        ->name('seller.product.sub_categories.ajax.list');
    Route::get('/ajax/child-categories/{subcategory_id}', 'ItemController@ajaxGetChildCategories')
        ->name('seller.product.child_categories.ajax.list');
    Route::post('/ajax/saveImage/', 'ItemController@saveImgAjax')->name('seller.item.saveImageAjax');
});

Route::group(['prefix' => 'collections'],function (){
    Route::get('/','CollectionController@index')->name('seller.product.collection.index');
    Route::get('/create/{collection}','CollectionController@create')->name('seller.product.collection.create');
    Route::post('/store/{collection}','CollectionController@store')->name('seller.product.collection.store');
    Route::get('/edit/{collection}','CollectionController@edit')->name('seller.product.collection.edit');
    Route::put('/update/{collection}','CollectionController@update')->name('seller.product.collection.update');
});
