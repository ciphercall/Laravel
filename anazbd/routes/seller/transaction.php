<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'transactions'], function () {
    Route::get('/', 'TransactionController@index')->name('seller.transaction.index');
});

Route::group(['prefix' => 'withdrawals'], function () {
    Route::get('/create', 'WithdrawRequestController@create')->name('seller.withdrawal.create');
    Route::post('/store', 'WithdrawRequestController@store')->name('seller.withdrawal.store');
    Route::delete('/{id}', 'WithdrawRequestController@destroy')->name('seller.withdrawal.destroy');
    Route::get('/', 'WithdrawRequestController@index')->name('seller.withdrawal.index');
});
