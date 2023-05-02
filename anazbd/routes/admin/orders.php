<?php

use App\Http\Controllers\Backend\ChalanController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'self-order'],function (){
    Route::get('/','SelfOrderController@index')->name('admin.self-order.pending.index');
    Route::get('/{id}/show','SelfOrderController@show')->name('admin.self-order.pending.show');
});


Route::group(['prefix' => 'order-creator'], function() {
    Route::get('/create','AdminOrderController@create')->name('admin.order.create');
});


Route::group(['prefix' => 'orders','namespace' => 'Order','middleware'=>'can:view_orders'],function (){

    Route::put('/status/{order}','OrderController@statusUpdate')->name('admin.orders.status');
    Route::put('/chalan/status/{chalan}','OrderController@statusUpdateChalan')->name('admin.chalan.status');
    Route::get('/item/{order_item}','OrderController@deactiveItem')->name('admin.orders.deactivate.item');
    Route::get('/order/export','OrderController@exportOrder')->name('admin.order.export');
    Route::get('/invoice/export','OrderController@exportInvoice')->name('admin.invoice.export');
    // Pending Orders
    Route::group(['prefix' => 'pending'],function (){
        
        Route::group(['middleware'=>'can:view_pending_orders'], function() {
            Route::get('/','PendingController@index')->name('admin.orders.pending.index');
            Route::get('/show/{order}','PendingController@show')->name('admin.orders.pending.show');
        });
        
        Route::group(['middleware'=>'can:edit_pending_orders'], function() {
            Route::get('/edit/{order}','PendingController@edit')->name('admin.orders.pending.edit');
            Route::put('/update/{order}','PendingController@update')->name('admin.orders.pending.update');
        });
        
        Route::delete('/delete/{order}','PendingController@delete')->name('admin.orders.pending.delete');
        
    });

    // Accepted Orders
    Route::group(['prefix' => 'accepted'],function (){

        Route::group(['middleware'=>'can:view_accepted_orders'], function() {
            Route::get('/','AcceptedController@index')->name('admin.orders.accepted.index');
            Route::get('/show/{order}','AcceptedController@show')->name('admin.orders.accepted.show');
        });
        Route::group(['middleware'=>'can:edit_accepted_orders'], function() {
            Route::get('/edit/{order}','AcceptedController@edit')->name('admin.orders.accepted.edit');
            Route::put('/update/{order}','AcceptedController@update')->name('admin.orders.accepted.update');
        });
        
    });

    // 3. Product pickup from Seller
    Route::group(['prefix' => 'picked'],function(){
        Route::get('/','PickedUpController@index')->name('admin.orders.picked.index');
    });

    // 4. Product Arrived at our Warehouse
    Route::group(['prefix' => 'arrived'],function(){
        Route::get('/','ArrivedController@index')->name('admin.orders.arrived.index');
    });

    // 5. Quality Check
    Route::group(['prefix' => 'quality-control'],function(){
        Route::get('/','QualityController@index')->name('admin.orders.qc.index');
    });

    // 6. Packing
    Route::group(['prefix' => 'packing'],function(){
        Route::get('/','InPackingController@index')->name('admin.orders.in-packing.index');
    });

    // 9. Delivery Date enhanced
    Route::group(['prefix' => 'delivery-date-enhanced'],function(){
        Route::get('/','DeliveryDateEnhancedController@index')->name('admin.orders.delivery-date-enhanced.index');
    });

    // Chalan
    Route::group(['prefix' => 'chalan'],function (){
        
        Route::group(['middleware'=>'can:view_invoices'], function() {
            Route::get('/','ChalanController@index')->name('admin.orders.chalan.index');
            Route::get('/show/{chalan}','ChalanController@show')->name('admin.orders.chalan.show');
        });
        Route::group(['middleware'=>'can:create_invoice'], function() {
            Route::get('/create/{order?}','ChalanController@create')->name('admin.orders.chalan.create');
            Route::get('/{chalan_no}/items',[App\Http\Controllers\Backend\ChalanController::class,'getOrderItems'])->name('backend.chalan.items');

            Route::post('/store','ChalanController@store')->name('admin.orders.chalan.store');
        });
        Route::group(['middleware'=>'can:edit_invoice'], function() {
            Route::get('/edit/{chalan}','ChalanController@edit')->name('admin.orders.chalan.edit');
            Route::put('/update/{chalan}','ChalanController@update')->name('admin.orders.chalan.update');
        });

    });
 
    // on delivery Orders
    Route::group(['prefix' => 'on-delivery'],function (){
        Route::group(['middleware'=>'can:view_on_delivery_orders'],function(){
            Route::get('/','OnDeliveryController@index')->name('admin.orders.on-delivery.index');
            Route::get('/show/{chalan}','OnDeliveryController@show')->name('admin.orders.on-delivery.show');
        });
        Route::group(['middleware'=>'can:edit_on_delivery_orders'],function(){
            Route::get('/edit/{chalan}','OnDeliveryController@edit')->name('admin.orders.on-delivery.edit');
            Route::put('/update/{chalan}','OnDeliveryController@update')->name('admin.orders.on-delivery.update');
        });
        
    });

    // Not Delivered Orders
    Route::group(['prefix' => 'not-delivered'],function (){
        Route::group(['middleware'=>'can:view_not_delivered_orders'],function(){
            Route::get('/','NotDeliveredController@index')->name('admin.orders.not-delivered.index');
            Route::get('/show/{chalan}','NotDeliveredController@show')->name('admin.orders.not-delivered.show');
        });
        Route::group(['middleware'=>'can:edit_not_delivered_orders'],function(){
            Route::get('/edit/{chalan}','NotDeliveredController@edit')->name('admin.orders.not-delivered.edit');
            Route::put('/update/{chalan}','NotDeliveredController@update')->name('admin.orders.not-delivered.update');
        });
        
    });

    // Delivered Orders
    Route::group(['prefix' => 'delivered'],function (){
        Route::group(['middleware'=>'can:view_delivered_orders'],function(){
            Route::get('/','DeliveredController@index')->name('admin.orders.delivered.index');
            Route::get('/show/{chalan}','DeliveredController@show')->name('admin.orders.delivered.show');
        });
        Route::group(['middleware'=>'can:edit_delivered_orders'],function(){
            Route::get('/edit/{chalan}','DeliveredController@edit')->name('admin.orders.delivered.edit');
            Route::put('/update/{chalan}','DeliveredController@update')->name('admin.orders.delivered.update');
        });
    });

    // Cancelled Orders
    Route::group(['prefix' => 'cancelled'],function (){
        Route::group(['middleware'=>'can:view_cancelled_orders'],function(){
            Route::get('/','CancelledController@index')->name('admin.orders.cancelled.index');
            Route::get('/show/{order}','CancelledController@show')->name('admin.orders.cancelled.show');
        });
        Route::group(['middleware'=>'can:edit_cancelled_orders'],function(){
            Route::get('/edit/{order}','CancelledController@edit')->name('admin.orders.cancelled.edit');
            Route::put('/update/{order}','CancelledController@update')->name('admin.orders.cancelled.update');
        });
    });

});
