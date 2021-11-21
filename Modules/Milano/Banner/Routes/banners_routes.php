<?php
Route::group(["namespace" => "Milano\Banner\Http\Controllers",
    'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->resource('banners', 'BannerController');
    $router->patch('banners/{banner}/accept', 'BannerController@accept')->name('banners.accept');
    $router->patch('banners/{banner}/reject', 'BannerController@reject')->name('banners.reject');
});
