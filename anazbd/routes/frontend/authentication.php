<?php

use Illuminate\Support\Facades\Route;

// Auth

Route::group(['prefix' => '/', 'namespace' => 'Auth'], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('frontend.user.login.form');

    Route::group(['prefix' => 'simple_login'],function () {
        Route::post('/otp','SimpleLoginController@sendOTP')->name('frontend.user.simple-login.otp');
        Route::post('/login','SimpleLoginController@login')->name('frontend.user.simple-login.login');
    });
    
//    Route::get('/login_reg', function (){
//        return view('mobile.pages.login_reg_combined');
//    })->name('mobile.user.combined');
//
//    Route::get('/login_reg_frnt', function (){
//        return view('frontend.pages.login_reg_combined');
//    })->name('frontend.user.combined');

    Route::get('/iframe-login', 'LoginController@showIframeLoginForm')->name('frontend.user.login.iframe');
//    Route::get('/register', 'LoginController@showRegisterForm')->name('frontend.user.register.form');
    Route::post('/register', 'LoginController@register')->name('frontend.user.register.post');
    Route::post('/customer/sendOTP', 'LoginController@sendOTP')->name('frontend.otp.send');
    Route::post('/customer/verifyOTP', 'LoginController@verifyOTP')->name('frontend.otp.verify');
    Route::post('/customer/register', 'LoginController@ajaxRegister')->name('frontend.user.register.ajax');
    Route::post('/customer/login', 'LoginController@ajaxLogin')->name('frontend.user.login.ajax');
    Route::post('/reset/otp','ForgotPasswordController@sendOTP')->name('frontend.reset.otp');
    Route::post('/reset/password','ForgotPasswordController@resetPassword')->name('frontend.reset.password');
    /*
        ! For New Registration
    */
    Route::post('/customer/register/otp', 'RegisterController@completeRegistration')->name('frontend.user.register');


    Route::patch('/password/change','ChangePasswordController@update')->name('frontend.user.password.change');

    Route::get('/sign-in/facebook/redirect','FacebookOauthController@redirect')->name('sign-in.facebook.redirect');
    Route::get('/sign-in/facebook/callback','FacebookOauthController@callback')->name('sign-in.facebook.callback');

    Route::get('/sign-in/google/redirect','GoogleOauthController@redirect')->name('sign-in.google.redirect');
    Route::get('/sign-in/google/callback','GoogleOauthController@callback')->name('sign-in.google.callback');
    Route::post('customer/register/otp/resend','RegisterController@otpResend')->name('sign-up.otp.resend');



//    ajax sign-in
    Route::post('/ajaxlogin', 'RegisterController@sessionLessPassChange')->name('ajaxLogin');
});
