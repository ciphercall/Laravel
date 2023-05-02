<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '/blog'], function () {
    Route::get('/', 'BlogController@index')->name('blog');
    Route::get('/{slug}', 'BlogController@show')->name('blog.show');
});
