<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ChalanController;

Route::group(['prefix' => 'chalan','middleware' => 'can:manage_invoice_old_panel'], function () {

    Route::get('/',[ChalanController::class,'index'])->name('backend.chalan.index');
    Route::get('/create',[ChalanController::class,'create'])->name('backend.chalan.create');
    Route::post('/store',[ChalanController::class,'store'])->name('backend.chalan.store');
    Route::get('/{no}/view',[ChalanController::class,'view'])->name('backend.chalan.view');
    Route::get('/{no}/edit',[ChalanController::class,'edit'])->name('backend.chalan.edit');
    Route::put('/{id}/update',[ChalanController::class,'update'])->name('backend.chalan.update');

    Route::get('/{no}/cancel/{to}',[ChalanController::class,'cancel'])->name('backend.chalan.cancel');
    Route::get('/{no}/not-delivered/{to}',[ChalanController::class,'notDelivered'])->name('backend.chalan.not-delivered');
    Route::get('/{no}/renew/{to}',[ChalanController::class,'renew'])->name('backend.chalan.renew');
});