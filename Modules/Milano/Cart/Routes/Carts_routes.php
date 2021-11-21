<?php
Route::group(["namespace" => "Milano\Cart\Http\Controllers", 'middleware' =>
    ['web', 'auth', 'verified']], function ($router) {

    $router->get('cart' , 'CartController@myCart')->name('cart.product');
   $router->post('cart' , 'CartController@addToCart')->name('cart.add');
   $router->delete('cart' , 'CartController@CartDelete')->name('cart.delete');
    $router->put('cart' , 'CartController@update')->name('cart.update');
});


