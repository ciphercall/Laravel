<?php




use Illuminate\Support\Facades\Route;

// flash sale
// Route::group(['prefix' => 'flash-sales'], function () {
//     Route::get('/', 'FlashSaleController@index')->name('backend.campaign.flash_sale.index');
//     Route::get('/create', 'FlashSaleController@create')->name('backend.campaign.flash_sale.create');
//     Route::get('/edit/{id}', 'FlashSaleController@edit')->name('backend.campaign.flash_sale.edit');

//     Route::post('/store', 'FlashSaleController@store')->name('backend.campaign.flash_sale.store');
//     Route::post('/update/{id}', 'FlashSaleController@update')->name('backend.campaign.flash_sale.update');
//     Route::get('/delete/{id}', 'FlashSaleController@destroy')->name('backend.campaign.flash_sale.destroy');
// });

// Coupons
Route::group(['prefix' => 'coupons','middleware' => 'can:view_coupons'], function () {
    Route::get('/', 'CouponController@index')->name('admin.campaign.coupons.index');
    Route::get('/create', 'CouponController@create')->name('admin.campaign.coupons.create');
    Route::get('/edit/{id}', 'CouponController@edit')->name('admin.campaign.coupons.edit');
    Route::get('/helper','CouponController@helper')->name('admin.campaign.coupons.helper');
    // non view
    Route::get('/destroy/{id}', 'CouponController@destroy')->name('admin.campaign.coupons.destroy');
    Route::post('/store', 'CouponController@store')->name('admin.campaign.coupons.store');
    Route::post('/update/{id}', 'CouponController@update')->name('admin.campaign.coupons.update');
});


Route::group(['prefix' => 'offers'], function() {
    Route::get('/','PromotionalOfferController@index')->name('admin.campaign.offer.index');
    Route::get('/create','PromotionalOfferController@create')->name('admin.campaign.offer.create');
    Route::get('/edit/{id}','PromotionalOfferController@edit')->name('admin.campaign.offer.edit');
    // Route::get('/helper','PromotionalOfferController@helper')->name('admin.campaign.offer.helper');
    Route::get('/destroy/{id}','PromotionalOfferController@destroy')->name('admin.campaign.offer.destroy');
    Route::post('/store','PromotionalOfferController@store')->name('admin.campaign.offer.store');
    Route::post('/update/{id}','PromotionalOfferController@update')->name('admin.campaign.offer.update');
});





























?>