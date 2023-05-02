<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/admin','middleware' => 'can:manage_admin_old_panel'], function (){
    Route::get('/','AdminController@index')->name('backend.admin.index');
    Route::get('/create','AdminController@create')->name('backend.admin.create');
    Route::post('/store','AdminController@store')->name('backend.admin.store');
    Route::get('/edit/{admin}','AdminController@edit')->name('backend.admin.edit');
    Route::post('/update/{id}','AdminController@update')->name('backend.admin.update');
    Route::get('/delete/{admin}','AdminController@destroy')->name('backend.admin.destroy');
});