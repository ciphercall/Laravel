<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'comment','middleware' => 'can:manage_comment_old_panel'], function () {

    Route::get('/unpublished','CommentController@unpublished')->name('backend.comment.unpublished');
    Route::get('/published','CommentController@published')->name('backend.comment.published');
    Route::get('/show/{id}','CommentController@show')->name('backend.comment.show');
    Route::get('/approve/{id}','CommentController@approve')->name('backend.comment.approve');
    Route::get('/delete/{id}','CommentController@destroy')->name('backend.comment.destroy');
});
