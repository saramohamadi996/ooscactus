<?php
Route::group(["namespace" => "Milano\Ads\Http\Controllers",
    'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->resource('adss', 'AdsController');
    $router->patch('adss/{ads}/accept', 'AdsController@accept')->name('adss.accept');
    $router->patch('adss/{ads}/reject', 'AdsController@reject')->name('adss.reject');
});
