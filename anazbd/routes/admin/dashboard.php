<?php

use Illuminate\Support\Facades\Route;


Route::get('/','DashboardController@index')->name('admin.dashboard.index');

// Route::get('/',function(){
//     return view('admin.pages.dashboard');
// })->name('admin.dashboard.index');

Route::group(['prefix' => 'settings'],function(){
    
    Route::post('/point/chart','SiteSettingController@storePoint')->name('admin.point-chart.store');
    Route::delete('/point-chart/{id}','SiteSettingController@deletePoint')->name('admin.point-chart.delete');
    
    Route::get('/site','SiteSettingController@index')->name('admin.site.setting.index');
    Route::post('/site','SiteSettingController@store')->name('admin.site.setting.store');
    Route::post('/subscriber','DeliveredNotifySubscriberController@store')->name('admin.site.subscriber.store');
    Route::get('/subscriber/{id}/status','DeliveredNotifySubscriberController@updateStatus')->name('admin.site.subscriber.status');

    Route::group(['prefix' => 'banks'], function() {
        Route::get('/','BankInfoController@index')->name('admin.bankinfo.index');
        Route::get('/{id}','BankInfoController@delete')->name('admin.bankinfo.delete');
        Route::post('/','BankInfoController@store')->name('admin.bankinfo.store');
    });

});

Route::group(['prefix' => 'users','middleware'=>'can:view_all_users'],function(){

    
    Route::get('/create','CustomerController@create')->name('admin.customer.create');
    
    Route::get('/customers','CustomerController@index')->name('admin.users.customers');
    Route::get('/customer/{id}','CustomerController@edit')->name('admin.users.customer.edit');
    Route::patch('/customer/{id}','CustomerController@update')->name('admin.users.customer.update');
    Route::get('/customer/{id}/history','CustomerController@history')->name('admin.users.customer.history');
    Route::get('/customer/{id}/status','CustomerController@toggleStatus')->name('admin.users.customer.toggle');
    Route::delete('/customer/{id}','CustomerController@destroy')->name('admin.users.customer.delete');

    Route::get('/sellers','SellerController@index')->name('admin.users.sellers');
    Route::get('/seller/{id}','SellerController@edit')->name('admin.users.seller.edit');
    Route::get('/seller/{id}/history','SellerController@history')->name('admin.users.seller.history');

    Route::group(['prefix' => 'admin','middleware'=>'can:view_admins'],function(){
        
        Route::get('/','AdminController@index')->name('admin.admin.index');
        Route::post('/store','AdminController@store')->name('admin.admin.store');
        // Route::put('/update/{id}','AdminController@update')->name('admin.admin.update');
        Route::delete('/{id}','AdminController@delete')->name('admin.admin.delete');
        
    });
});



Route::group(['prefix' => 'roles','middleware'=>'can:view_roles'], function() {
    Route::get('/','RoleController@index')->name('admin.role.index');
    Route::post('/store','RoleController@store')->name('admin.role.store');
    // Route::put('/update','RoleController@update')->name('admin.role.update');
    Route::delete('/{id}','RoleController@delete')->name('admin.role.delete');
});

Route::group(['prefix' => 'permissions','middleware'=>'can:view_permissions'], function() {
    Route::get('/','PermissionController@index')->name('admin.permission.index');
    Route::post('/store','PermissionController@store')->name('admin.permission.store');
    // Route::put('/update','PermissionController@update')->name('admin.permission.update');
    Route::delete('/{id}','PermissionController@delete')->name('admin.permission.delete');
});


Route::group(['middleware'=>'can:view_jobs'], function() {
    Route::resource('/jobs','JobController');
    Route::get('/jobs/{id}/status','JobController@toggleStatus')->name('jobs.status.toggle');
});


