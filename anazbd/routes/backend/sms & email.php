<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/sms-config','middleware' => 'can:manage_sms_config_old_panel'], function () {
    Route::get('/', 'SMSConfigController@index')->name('backend.sms_config.get');
    Route::post('/{id}', 'SMSConfigController@update')->name('backend.sms_config.post');
});

Route::group(['prefix' => '/email-config','middleware' => 'can:manage_email_config_old_panel'], function () {
    Route::get('/', 'EmailConfigController@index')->name('backend.email_config.get');
    Route::post('/', 'EmailConfigController@update')->name('backend.email_config.post');
});
