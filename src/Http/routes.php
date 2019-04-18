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
                'uses' => 'OrderController@getMyOrderView'
            ]);
            Route::get('/orders', [
                'as' => 'shopping.orderView',
                'uses' => 'OrderController@getOrderTable',
                'middleware' => 'bouncer:order.view'
            ]);
            Route::get('/orders/{order_id}',[
                'as' => 'shopping.getOrder',
                'uses' => 'OrderController@getOrderView',
                'middleware' => 'bouncer:order.view'
            ]);
            Route::get('/orders/{order_id}/{action',[
                'as' => 'shopping.settle',
                'uses' => 'OrderController@settleOrder',
                'middleware' => 'bouncer:shopping.settle'
                ])->where(['action' => 'Reject|Pending|Progress|Complete']);
     });
    });

