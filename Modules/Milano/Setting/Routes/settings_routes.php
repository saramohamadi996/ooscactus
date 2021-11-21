<?php
Route::group(["namespace" => "Milano\Setting\Http\Controllers",
    'middleware' => ['web', 'auth', 'verified']
], function ($router) {
    $router->resource('settings', 'SettingController');
});
