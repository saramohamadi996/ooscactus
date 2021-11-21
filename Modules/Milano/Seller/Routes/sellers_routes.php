<?php
Route::group(["namespace" => "Milano\Seller\Http\Controllers",
    'middleware' => ['web', 'auth', 'verified']
], function ($router) {
    $router->resource('sellers', 'SellerController');

    $router->patch('sellers/{seller}/accept', 'SellerController@accept')->name('sellers.accept');
    $router->patch('sellers/{seller}/reject', 'SellerController@reject')->name('sellers.reject');
});
