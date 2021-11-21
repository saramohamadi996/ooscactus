<?php

Route::group(["namespace" => "Milano\Article\Http\Controllers", 'middleware' =>
    ['web', 'auth', 'verified']], function ($router) {
    $router->resource('articles', 'ArticleController');
    $router->patch('articles/{article}/accept', 'ArticleController@accept')->name('articles.accept');
    $router->patch('articles/{article}/reject', 'ArticleController@reject')->name('articles.reject');
    $router->get('articles/{article}/details', 'ArticleController@details')->name('articles.details');
});
