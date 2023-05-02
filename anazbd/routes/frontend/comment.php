<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'comment'], function () {
    Route::post('/{slug}', 'CommentController@store')->name('frontend.comment');
    Route::post('/{id}', 'CommentController@index')->name('frontend.commentall');
});


Route::group(['prefix' => 'question'], function() {
    Route::post('/{slug}','QuestionController@store')->name('frontend.question.store');
});

