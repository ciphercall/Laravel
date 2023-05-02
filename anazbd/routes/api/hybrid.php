<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'hybrid','namespace' => 'Hybird'], function() {
    Route::group(['prefix' => 'account'],function(){
        
        
        Route::group(['middleware' => 'auth:api',], function() {
            Route::get('/','UserController@account')->name('hybrid.user.account');
            Route::get('/order/{no}/','UserController@orderDetailsView');

        });
        
        Route::get('/{id}/no-auth','UserController@account')->name('hybrid.user.account.no-auth');
        Route::get('/order/{no}/view','UserController@orderTimelineView')->name('hybrid.order.view');
        Route::get('/order/{no}/details','UserController@orderDetailsView')->name('hybrid.order.details');

        Route::post('/password/update/{id}','UserController@changePassword')->name('hybrid.user.password.update');
        Route::post('/profile/update/{id}','UserController@changeProfile')->name('hybrid.user.profile.update');
        
    });
});

