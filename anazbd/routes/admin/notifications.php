<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'push/notifications','middleware' => 'can:manage_push_notifications'], function() {
    Route::get('/','NotificationController@index')->name('admin.notification.index');
    Route::post('/send','NotificationController@send')->name('admin.notification.send');
});
