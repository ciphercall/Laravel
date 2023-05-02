<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'post_code','middleware' => 'can:manage_post_code_old_panel'], function () {
    Route::get('/', 'PostCodeController@index')->name('backend.area.post_code.index');
    Route::get('/post/create', 'PostCodeController@create')->name('backend.area.post_code.create');
    Route::get('/postCode/getCity/{divId}', 'PostCodeController@getCity')->name('postCode.getCity');

    Route::post('/postCode/create/', 'PostCodeController@store')
            ->name('backend.area.post_code.store');

    Route::get('/postCode/edit/{id}', 'PostCodeController@edit')
            ->name('backend.area.post_code.edit');

    Route::post('/postCode/update/{id}', 'PostCodeController@update')
            ->name('backend.area.post_code.update');

    Route::get('/postCode/destroy/{id}', 'PostCodeController@destroy')
            ->name('backend.area.post_code.destroy');
});


