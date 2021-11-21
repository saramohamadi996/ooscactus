<?php

namespace Milano\Seller\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Milano\RolePermissions\Models\Permission;
use Milano\Seller\Models\Seller;
use Milano\Seller\Policies\SellerPolicy;

class SellerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__. '/../Routes/sellers_routes.php');
        $this->loadViewsFrom(__DIR__. '/../Resources/Views', 'Sellers');
        $this->loadMigrationsFrom(__DIR__. '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__. '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__. '/../Resources/Lang/', "Sellers");
        Gate::policy(Seller::class,SellerPolicy::class);
    }

    public function boot()
    {
        config()->set('sidebar.items.sellers', [
            "icon" => "i-sellers",
            "title" => "همکاری با ما",
            "url" => route('sellers.index'),
            'permission'=>Permission::PERMISSION_MANAGE_SELLERS,
        ]);
    }
}
