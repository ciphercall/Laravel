<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'transactions'], function () {
    Route::get('/', 'TransactionController@index')->name('delivery.transaction.index');
});

Route::group(['prefix' => 'withdrawals'], function () {
    Route::get('/create', 'WithdrawRequestController@create')->name('delivery.withdrawal.create');
    Route::post('/store', 'WithdrawRequestController@store')->name('delivery.withdrawal.store');
    Route::delete('/{id}', 'WithdrawRequestController@destroy')->name('delivery.withdrawal.destroy');
    Route::get('/', 'WithdrawRequestController@index')->name('delivery.withdrawal.index');
});
