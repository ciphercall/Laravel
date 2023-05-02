<?php

use Illuminate\Support\Facades\Route;

//login
Route::get('/seller/login', 'Auth\SellerLoginController@showLoginForm')->name('seller.login.form');
Route::post('/seller/login', 'Auth\SellerLoginController@login')->name('seller.login.post');
Route::post('/seller/logout', 'Auth\SellerLoginController@logout')->name('seller.logout');
Route::post('/seller/sendOTP', 'Auth\SellerLoginController@sendOTP')->name('seller.otp.send');
Route::post('/seller/verifyOTP', 'Auth\SellerLoginController@verifyOTP')->name('seller.otp.verify');


//register
Route::get('/seller/register', 'Auth\SellerLoginController@showRegisterForm')->name('seller.register.form');
Route::post('/seller/register', 'Auth\SellerLoginController@register')->name('seller.register.post');
