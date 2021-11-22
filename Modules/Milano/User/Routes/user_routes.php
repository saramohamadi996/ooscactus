<?php

use Illuminate\Support\Facades\Route;

//Route::group(['namespace' => 'Milano\User\Http\Controllers', 'middleware' => 'web'],
//    function ($router) {
//        Route::mixin(new \Laravel\Ui\AuthRouteMethods());
//        Auth::routes(['verify' => true]);
//        Route::get('logout', 'Auth\LoginController@logout')->name('logout');
//    });

Route::group(['namespace' => 'Milano\User\Http\Controllers', 'middleware' => 'web', 'throttle:3,1'], function ($router) {
    Route::post('users/login', ['uses' => 'LoginController@login'])->name('users.login');
});
Route::post('/verify-code', ['uses' => 'VerifyCodeController@auth']);

Route::group(['namespace' => 'Milano\User\Http\Controllers', 'middleware' => ['web', 'auth']], function ($router) {
    Route::post('users/{user}/add/role', "UserController@addRole")->name('users.addRole');
    Route::delete('users/{user}/remove/{role}/role', "UserController@removeRole")->name('users.removeRole');
    Route::patch('users/{user}/manualVerify', "UserController@manualVerify")->name('users.manualVerify');
    Route::post('users/photo', "UserController@updatePhoto")->name('users.photo');
    Route::get('viewProfile', "UserController@viewProfile")->name('viewProfile');
    Route::get('edit-profile', "UserController@profile")->name('users.profile');
    Route::post('edit-profile', ["uses" => "UserController@updateProfile", "as" => 'users.profile']);
    Route::post('users/update-image', 'UserController@updateImage')->name('users.updateImage');
    Route::resource('users', "UserController");
    Route::get('user/{user}/image', "UserController@remove")->name('userImage.destroy');
});

