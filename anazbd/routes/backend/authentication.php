<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/anaz/superAdmin'],function (){
    Route::get('/login', 'Auth\BackendLoginController@showLoginForm')->name('backend.login.form');
    Route::post('/login', 'Auth\BackendLoginController@login')->name('backend.login.confirm');
    Route::post('/logout', 'Auth\BackendLoginController@logout')->name('backend.logout');
});

Auth::routes();
