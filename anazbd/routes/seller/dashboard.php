<?php
use Illuminate\Support\Facades\Route;


// seller dashboard start here
Route::group(['prefix' => '/'], function () {

	Route::get('/','HomeController@dashboard')->name('seller.dashboard.index');
    Route::get('/profile','HomeController@profile')->name('seller.profile.index');

	Route::post('/profile/image/{id}','ProfileController@updateImage')->name('seller.profile.update.image');

    //	[arman]
    Route::get('/profile/bank-info', 'SellerBankInfoController@sellerBankInfo')->name('seller.profile.bank-info');
    Route::post('seller/profile/bank-info/{id?}', 'SellerBankInfoController@addSellerBankInfo')->name('seller.bank-info');

    Route::get('/division/getCityByDivision/{divisionId}',[
        'uses' => 'ProfileController@getCityByDivision',
        'as'   => 'division/getCityByDivision'
    ]);
    Route::get('/cities/getPostCodeBycity/{cityId}',[
        'uses' => 'ProfileController@getPostCodeByCity',
        'as'   => 'cities/getPostCodeBycity'
    ]);
    Route::post('/seller/profile/{id?}/{businessId?}/{returnId?}', [
        'uses' => 'ProfileController@addSellerInfo',
        'as'   => 'seller.profile.add'
    ]);

//    Seller business address
    Route::get('division/getCityByDivisionForBusiness/{divisionId}', 'BusinessAddressController@getCityForBusiness')->name('division/getCityByDivisionForBusiness');
    Route::get('cities/getPostCodeByCitiesForBusinessAddress/{cityId}', 'BusinessAddressController@getPostCodeForBusiness')->name('cities/getPostCodeByCitiesForBusinessAddress');
//    Seller Return Address
    Route::get('division/getCityByDivisionForReturnAddress/{divisionId}', 'ReturnAddressController@getCityForReturn')->name('division/getCityByDivisionForReturnAddress');
    Route::get('cities/getPostcodeByCityForReturnAddress/{cityId}', 'ReturnAddressController@getPostCodeForReturn')->name('cities/getPostcodeByCityForReturnAddress');

});
