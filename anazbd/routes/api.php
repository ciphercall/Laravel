<?php

use App\Http\Controllers\Admin\Repositories\CouponValidityRepository;
use App\Http\Controllers\API\HomeController;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Coupon;
use App\Models\Role;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
// Route::post('/address','API/AccountController@address');

Route::group(['middleware' => 'auth:api','namespace' => "API"], function() {
    Route::get('/user',function(){
        $user = auth('api')->user();
        $user->load('division','city','area');
        return response()->json([
            'status' => "success",
            'msg' => "User Authenticated successfully.",
            "data" => $user                                                                                                                                                                                                                                    
        ], 200);
    });
    
    Route::post('/device/token','AccountController@saveDeviceToken');
    
    Route::get('/logout','AuthController@logout');

    Route::group(['prefix' => 'account'], function() {

        Route::get('/essential/counts','AccountController@getEssentialCount');

        Route::get('/','AccountController@index'); 

        Route::get('/orders','AccountController@orders');
        Route::get('/order/{no}','AccountController@orderDetails');
        Route::get('/order/view/{no}','AccountController@orderView');

        Route::post('/password','AccountController@passwordUpdate');
        Route::post('/update','AccountController@update');
        
        Route::get('/redeems', 'AccountController@getRedeems');
        Route::post('/redeem','AccountController@setRedeem');

        // get Divisions
        Route::get('/divisions', 'AccountController@divisions');
        
        //get cities
        Route::get('/cities/{division_id}', 'AccountController@cities');

        //get areas
        Route::get('/areas/{city_id}', 'AccountController@areas');

        // create or update address
        Route::post('/address','AccountController@address');

        //update password
        Route::post('/update/password','AccountController@updatePassword');

        //update account
        Route::post('/update/details','AccountController@updateInfo');
    });

    Route::group(['prefix' => 'wishlist'], function() {
        Route::get('/','WishlistController@index');
        Route::get('/store/{slug}','WishlistController@store');
        Route::delete('/{id}','WishlistController@destory');
    });
 
    Route::group(['prefix' => 'cart'],function(){
        Route::get('/','CartController@index');
        Route::get('/{id}/increase','CartController@increase');
        Route::get('/{id}/decrease','CartController@decrease');
        Route::get('/{id}/delete','CartController@delete');
        Route::post('/create','CartController@create');
        Route::post('/coupon/apply','CartController@couponAdd');
        Route::post('/redeem/apply','CartController@redeemAdd');
    });

    Route::group(['prefix' => 'checkout'],function (){
        Route::post('/cash-on-delivery','CheckoutController@cashOnDelivery');
        Route::post('/pay-online','CheckoutController@payOnline');
        Route::post('/pay-partial','CheckoutController@payPartial');

        Route::get('/helper',function (){
            $key = base64_encode('ysshamrat1');
            $encryptor = new \Illuminate\Encryption\Encrypter($key,'AES-128-CBC');
            $storeID = $encryptor->encrypt('anazbdlive');
            $storePassword = $encryptor->encrypt('5F5334AC857FD64509');
            return response()->json([
                'status' => 'success',
                'msg' => 'Checkout Helpers are fetched.',
                'data' => [
                    'ssl_store_id' => $storeID,
                    'ssl_store_key' => $storePassword,
                ]
            ]);
        });
    });
});

Route::group(['namespace' => 'API', 'prefix' => 'self-order'], function() {
    Route::post('/','SelfOrderController@store');
});

Route::group(['namespace' => 'API'], function() {

    Route::get('/home','HomeController@index');
    Route::get('/home/next','HomeController@homeProducts');

    Route::get('/digital_sheba','HomeController@getDigitalSheba');
    Route::get('/discounts','HomeController@getDiscounts');
    Route::get('/collections','HomeController@getCollections');
    Route::get('/anaz_empire','HomeController@getEmpire');
    Route::get('/anaz_spotlight','HomeController@getSpotlight');
    Route::get('/recipes','HomeController@recipes');
    Route::get('/recipe/{slug}','HomeController@getRecipe');
    /*
        ! Categories
    */
    Route::get('/categories','CategoryController@getCategories');
    Route::get('/subcategories/{slug}','CategoryController@getSubCategories');
    Route::get('/childcategories/{slug}','CategoryController@getChildCategories');
    Route::get('/category/{slug}','CategoryController@getCategoryProducts');
    Route::get('/subcategory/{slug}','CategoryController@getSubcategoryProducts');
    Route::get('/childcategory/{slug}','CategoryController@getChildCategoryProducts');
    Route::get('/search/tags','SearchController@searchtags');
    Route::get('/search','SearchController@search');

    /*
        ! Shop Products
    */
    Route::get('/shop/{slug}','SellerController@getShopProducts');

    /*
        ! Single Product
    */
    
    Route::group(['prefix' => 'product'], function() {
        Route::get('/{slug}', 'ProductController@show');
        Route::get('/{slug}/reviews', 'ProductController@reviews');
    });
    

    /*
        ! Single Collection Products
    */
    Route::get('/collection/{slug}','CollectionController@getCollectionProducts');


    /*
        ! Privacy Policy & Terms and conditions
    */
    Route::get('/privacy-policy','HomeController@privacyPolicy');
    Route::get('/terms-and-conditions','HomeController@termsAndConditions');


    /*
        ! Authentication
    */
    Route::post('/login','AuthController@login');

    // Otp
    Route::post('/send/otp','AuthController@sendOTP');
    Route::post('/register','AuthController@verifyOTP');

    // forgot password
    Route::group(['prefix' => 'forgot-password'],function(){
        // send otp api
        Route::post('/send/otp','ForgotPasswordController@sendOTP');
        // reset password api
        Route::post('/reset','ForgotPasswordController@reset');
    });


});

