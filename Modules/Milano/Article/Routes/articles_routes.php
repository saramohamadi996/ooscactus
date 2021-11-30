<?php

Route::group(["namespace" => "Milano\Article\Http\Controllers", 'middleware' =>
    ['web', 'auth', 'verified']], function ($router) {

    $router->resource('articles', 'ArticleController');
    $router->get('toggle/{article}/toggle', 'ArticleController@toggle')->name('articles.toggle');
    $router->get('articles/{article}/details', 'ArticleController@details')->name('articles.details');
});
