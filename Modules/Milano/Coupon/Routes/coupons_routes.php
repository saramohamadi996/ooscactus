<?php

Route::group(["namespace" => "Milano\Coupon\Http\Controllers", 'middleware' =>
    ['web', 'auth', 'verified']], function ($router) {
    $router->resource('coupons', 'CouponController');
    $router->patch('coupons/{coupon}/accept', 'CouponController@accept')->name('coupons.accept');
    $router->patch('coupons/{coupon}/reject', 'CouponController@reject')->name('coupons.reject');
});
