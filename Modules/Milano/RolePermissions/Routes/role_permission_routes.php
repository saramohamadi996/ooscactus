<?php

use Illuminate\Support\Facades\Route;

Route::group(["namespace" => "Milano\RolePermissions\Http\Controllers", 'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->resource('role-permissions', 'RolePermissionsController');
});
