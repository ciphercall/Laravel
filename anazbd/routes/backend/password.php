<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'password'], function () {
    Route::get('edit', 'UserController@changePassword')->name('user.password.edit');
    Route::post('edit', 'UserController@updatePassword')->name('user.password.update');;
});
