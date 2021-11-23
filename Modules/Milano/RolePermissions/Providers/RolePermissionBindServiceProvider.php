<?php

namespace Milano\RolePermissions\Providers;

use Illuminate\Support\ServiceProvider;
use Milano\RolePermissions\Repositories\Interfaces\PermissionRepositoryInterface;
use Milano\RolePermissions\Repositories\Interfaces\RoleRepositoryInterface;
use Milano\RolePermissions\Repositories\PermissionRepository;
use Milano\RolePermissions\Repositories\RoleRepository;

class RolePermissionBindServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Define your route model bindings
     */
    public function boot()
    {
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    }
}
