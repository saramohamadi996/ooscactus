<?php
Route::group(["namespace" => "Milano\Order\Http\Controllers", 'middleware' =>
    ['web', 'auth', 'verified']], function ($router) {
    $router->post('orders/checkout' , 'OrderController@checkout')->name('orders.checkout');
    $router->post('orders/buy' , 'OrderController@OrderBuy')->name('orders.buy');
    $router->get('orders/details/{id}', 'OrderController@details')->name('orders.details');
    $router->patch('orders/{order}/preparing', 'OrderController@preparing')->name('orders.preparing');
    $router->patch('orders/{order}/sent', 'OrderController@sent')->name('orders.sent');

    $router->get('orders/search', 'OrderController@search')->name('orders.search');
    $router->resource('orders', 'OrderController');
});


