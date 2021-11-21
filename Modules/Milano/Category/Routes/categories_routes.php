<?php
Route::group(["namespace" => "Milano\Category\Http\Controllers", 'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->resource('categories', 'CategoryController');
});
