<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/quick-page'], function () {
    Route::get('/{slug}', 'QuickPageController@index')->name('frontend.quickpage');
});
