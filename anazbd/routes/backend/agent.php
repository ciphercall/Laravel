<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/agent','middleware' => 'can:manage_agent_old_panel'], function (){
    Route::get('/','AgentController@index')->name('backend.agent.index');
    Route::get('/create','AgentController@create')->name('backend.agent.create');
    Route::post('/store','AgentController@store')->name('backend.agent.store');
    Route::get('/edit/{agent}','AgentController@edit')->name('backend.agent.edit');
    Route::get('/show/{agent}','AgentController@show')->name('backend.agent.show');
    Route::post('/update/{agent}','AgentController@update')->name('backend.agent.update');
    Route::get('/delete/{agent}','AgentController@destroy')->name('backend.agent.destroy');

    //ajax request for postcode /lcoatedarea
    Route::get('/located/area/{cityId}', 'AgentController@locatedarea')->name('located.area');
});
