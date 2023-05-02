<?php

use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'menu','middleware' => 'can:manage_menu'], function() {
    Route::get('/','MenuController@index')->name('admin.menu.index');
    Route::post('/store','MenuController@store')->name('admin.menu.store');
    Route::patch('/update','MenuController@update')->name('admin.menu.update');
    Route::delete('/delete/{id}','MenuController@delete')->name('admin.menu.delete');
});
