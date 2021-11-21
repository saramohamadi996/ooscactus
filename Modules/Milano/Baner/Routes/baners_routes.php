<?php
Route::group(["namespace" => "Milano\Baner\Http\Controllers",
    'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->resource('baners', 'BanerController');
    $router->patch('baners/{baner}/accept', 'BanerController@accept')->name('baners.accept');
    $router->patch('baners/{baner}/reject', 'BanerController@reject')->name('baners.reject');
});
