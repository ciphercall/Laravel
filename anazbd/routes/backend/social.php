<?php  
	

	// social
Route::group(['prefix' => '/social','middleware' => 'can:manage_social_old_panel'], function (){
    Route::get('/','SocialController@index')->name('backend.social.index');
    Route::post('/createupdate/{id?}','SocialController@createupdate')->name('backend.social.createupdate');
});
