<?php
Route::group(["namespace" => "Milano\Product\Http\Controllers",
    'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->resource('products', 'ProductController');
    $router->patch('products/{product}/accept', 'ProductController@accept')->name('products.accept');
    $router->patch('products/{product}/reject', 'ProductController@reject')->name('products.reject');
    $router->get('products/{product}/details', 'ProductController@details')->name('products.details');
    $router->get('products/{product}/search', 'ProductController@search')->name('products.search');
    $router->post('products/coupon', 'ProductController@coupon')->name('products.coupon');

});
