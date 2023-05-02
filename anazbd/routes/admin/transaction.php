<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'transactions','middleware'=>'can:view_transactions'], function () {
    Route::get('/create', 'TransactionController@create')->name('admin.transaction.create');
    Route::get('/store', 'TransactionController@store')->name('admin.transaction.store');
    Route::get('/','TransactionController@index')->name('admin.transactions');
//    Route::get('/create', function (){
//        return view('admin.transactions.create');
//    })->name('backend.transaction.create');

    Route::post('/createAjax', 'TransactionController@createPst')->name('admin.transaction.AjaxCreate');

    
    Route::get('/point','TransactionController@points')->name('admin.transaction.point');
    
});
