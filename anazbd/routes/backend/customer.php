<?php

use Illuminate\Support\Facades\Route;

// Offer page
Route::group(['prefix' => '/customer','middleware' => 'can:manage_customer_old_panel'], function (){
    Route::get('/','CustomerController@index')->name('backend.customer.index');
    Route::get('/show','CustomerController@show')->name('backend.customer.show');
    Route::get('/delete/{id}','CustomerController@destroy')->name('backend.customer.destroy');

    //seach
    Route::post('seach','CustomerController@search')->name('admin.user.search');

});
