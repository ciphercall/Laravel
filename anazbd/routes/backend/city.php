<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'city','middleware' => 'can:manage_city_old_panel'], function () {
   Route::get('/', 'CityController@index')->name('backend.area.city.index');
   Route::get('/city/create', 'CityController@create')->name('backend.area.city.create');
   Route::post('/city/store', 'CityController@store')->name('backend.area.city.store');
   Route::get('/city/show/{id}', 'CityController@show')->name('backend.area.city.show');
   Route::post('/city/update/{id}', 'CityController@update')->name('backend.area.city.update');
   Route::get('/city/destroy/{id}', 'CityController@destroy')->name('backend.area.city.destroy');
});


