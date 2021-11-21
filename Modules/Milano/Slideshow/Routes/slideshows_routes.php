<?php
Route::group(["namespace" => "Milano\Slideshow\Http\Controllers",
    'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->resource('slideshows', 'SlideshowController');
    $router->patch('slideshows/{slideshow}/accept', 'SlideshowController@accept')->name('slideshows.accept');
    $router->patch('slideshows/{slideshow}/reject', 'SlideshowController@reject')->name('slideshows.reject');
});
