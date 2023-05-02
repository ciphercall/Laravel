<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'econfig','middleware' => 'can:manage_econfig_old_panel'], function () {
    // vat
    Route::get('/', 'EconfigController@index')->name('backend.econfig.vat');
    Route::get('vat/edit/{subCategory}', 'EconfigController@edit')->name('backend.econfig.vats.edit');
    // non view
    Route::post('vat/update/{subCategory}', 'EconfigController@update')
        ->name('backend.econfig.vats.update');
    Route::get('vat/destroy/{subCategory}', 'EconfigController@destroy')
        ->name('backend.econfig.vats.destroy');


    // commission
    Route::get('/commission', 'EconfigController@commissionindex')->name('backend.econfig.commission');
    Route::get('commission/edit/{subCategory}', 'EconfigController@commissionedit')
        ->name('backend.econfig.commission.edit');
    // non view
    Route::post('/commission/update/{subCategory}', 'EconfigController@commissionupdate')
        ->name('backend.econfig.commissions.update');
    Route::get('/commission/destroy/{subCategory}', 'EconfigController@commissiondestroy')
        ->name('backend.econfig.commissions.destroy');


    // Delivery Size
    Route::get('/delivery-size', 'DeliverySizeController@index')
        ->name('backend.econfig.delivery-size.index');
    Route::get('/delivery-size/create', 'DeliverySizeController@create')
        ->name('backend.econfig.delivery-size.create');
    Route::get('/delivery-size/edit/{id}', 'DeliverySizeController@edit')
        ->name('backend.econfig.delivery-size.edit');
    // non view
    Route::post('/delivery-size/store', 'DeliverySizeController@store')
        ->name('backend.econfig.delivery-size.store');
    Route::post('/delivery-size/update/{id}', 'DeliverySizeController@update')
        ->name('backend.econfig.delivery-size.update');
    Route::get('/delivery-size/destroy/{id}', 'DeliverySizeController@destroy')
        ->name('backend.econfig.delivery-size.destroy');
});
