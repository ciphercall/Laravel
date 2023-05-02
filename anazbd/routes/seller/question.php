<?php

use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'questions'], function () {
    Route::get('/answered','QuestionController@allAnswered')->name('seller.questions.answered');
    Route::get('/unanswered','QuestionController@allunanswered')->name('seller.questions.unanswered');
    Route::post('/update','QuestionController@answer')->name('seller.question.update');
    
});