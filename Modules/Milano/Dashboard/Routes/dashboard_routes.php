<?php

Route::group(['namespace' => 'Milano\Dashboard\Http\Controllers',
    'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->get('/dashboard', 'DashboardController@dashboard')->name('dashboard');
});
