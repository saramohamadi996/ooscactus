<?php

namespace Milano\Baner\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Milano\Baner\Models\Baner;
use Milano\Baner\Policies\BanerPolicies;
use Milano\RolePermissions\Models\Permission;

class BanerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/baners_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Baners');
        $this->loadJsonTranslationsFrom(__DIR__. '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__. '/../Resources/Lang/', "Baners");
        Gate:policy(Baner::class, BanerPolicies::class);
    }

    public function boot()
    {
        $this->app->booted(function(){
            config()->set('sidebar.items.baners', [
                "icon" => "i-baners",
                "title" => "شبکه های اجتماعی",
                "url" => route('baners.index'),
                'permission'=>Permission::PERMISSION_MANAGE_BANERS
            ]);
        });
    }
}
