<?php
Route::group(["namespace" => "Milano\Product\Http\Controllers",
    'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->resource('products', 'ProductController');
    $router->get('status/{product}/status', 'ProductController@status')->name('products.status');
    $router->get('toggle/{product}/toggle', 'ProductController@toggle')->name('products.toggle');
    $router->get('products/{product}/details', 'ProductController@details')->name('products.details');
    $router->get('products/{product}/search', 'ProductController@search')->name('products.search');
    $router->post('products/coupon', 'ProductController@coupon')->name('products.coupon');

});
