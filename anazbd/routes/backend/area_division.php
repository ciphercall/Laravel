<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'area_division','middleware' => 'can:manage_area_division_old_panel'], function () {
   Route::get('/', 'AreaDivisionController@index')
              ->name('backend.area.index');

   Route::get('/create/division', 'AreaDivisionController@create')
              ->name('backend.area.create-division');

   Route::post('/store/division', 'AreaDivisionController@store')
              ->name('backend.area.division.store');

   Route::get('/edit/division/{id}', 'AreaDivisionController@edit')
              ->name('backend.area.edit');

   Route::post('/update/division/{division}', 'AreaDivisionController@update')
              ->name('backend.area.division.update');

   Route::get('/destroy/division/{id}', 'AreaDivisionController@destroy')
              ->name('backend.area.destroy');
});

