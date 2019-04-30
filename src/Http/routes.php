<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/5/2019
 * Time: 6:47 PM
 */
    Route::group(
    [
        'namespace' => 'Fordav3\Seat\Shopping\Http\Controllers',
        'prefix' => 'shopping'
    ], function () {
     Route::group([
         'middleware' => ['web', 'auth'],
         ], function () {
            Route::get('/', [
                'as' => 'shopping.myorders',
                'uses' => 'OrderController@getMyOrderView',
                'middleware' => 'bouncer:shopping.order'
            ]);
            Route::get('/orders', [
                'as' => 'shopping.orderView',
                'uses' => 'OrderController@getOrderView',
                'middleware' => 'bouncer:shopping.order'
            ]);
            Route::get('/orders/order_id={order_id}',[
                'as' => 'shopping.getOrder',
                'uses' => 'OrderController@getOrderView',
                'middleware' => 'bouncer:shopping.order'
            ]);
            Route::get('/orders/order_id={order_id}/{action}',[
                'as' => 'shopping.settle',
                'uses' => 'OrderController@settleOrder',
                'middleware' => 'bouncer:shopping.hauler'
                ])->where(['action' => 'Reject|Pending|Progress|Complete']);
            Route::post('/orders/neworder/',[
               'as' =>          'shopping.neworder',
               'uses' =>        'OrderController@createOrder'
            ]);
            Route::get('/orders/neworder/confirm/{order_id}/',[
                'as' =>         'shopping.confirm',
                'uses' =>       'OrderController@confirmOrder'
            ]);
            Route::get('/orders/neworder/cancel/{order_id}/',[
                'as' =>         'shopping.cancel',
                'uses' =>       'OrderController@cancelOrder'
            ]);
            Route::get('/handlerlist', [
                'as' =>         'shopping.handler.list',
                'uses' =>       'OrderController@getOrderList',
                'middleware' => 'bouncer:shopping.hauler'
            ]);
            Route::get('/orders/assigned/', [
               'as' =>          'shopping.handler.myassigned',
                'uses' =>       'OrderController@getMyAssignedOrders',
                'middleware' => 'bouncer:shopping.hauler'
            ]);
            Route::get('/orders/assigned/{$handler}', [
                'as' =>          'shopping.handler.assigned',
                'uses' =>       'OrderController@getAssignedOrders',
                'middleware' => 'bouncer:shopping.hauler'
            ]);
            Route::get('/orders/reject/{order_id}', [
                'as' =>         'shopping.rejectview',
                'uses' =>       'OrderController@rejectionView',
                'middleware' => 'bouncer:shopping.hauler'
            ]);
            Route::post('/orders/reject/', [
                'as' =>         'shopping.reject',
                'uses' =>       'OrderController@rejectOrder',
                'middleware' => 'bouncer:shopping.hauler'
            ]);
     });
    });

