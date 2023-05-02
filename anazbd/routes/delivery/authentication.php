<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/delivery/login', 'Auth\DeliveryController@showLoginForm')->name('delivery.login.form');
Route::post('/delivery/login', 'Auth\DeliveryController@login')->name('delivery.login.post');
Route::post('/delivery/logout', 'Auth\DeliveryController@logout')->name('delivery.logout');

Auth::routes();
