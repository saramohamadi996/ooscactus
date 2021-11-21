<?php
namespace Milano\Banner\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Milano\Banner\Models\Banner;
use Milano\Banner\Policies\BannerPolicies;
use Milano\RolePermissions\Models\Permission;

class BannerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/banners_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Banners');
        $this->loadJsonTranslationsFrom(__DIR__. '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__. '/../Resources/Lang/', "Banners");
        Gate:policy(Banner::class, BannerPolicies::class);
    }

    public function boot()
    {
        $this->app->booted(function(){
            config()->set('sidebar.items.banners', [
                "icon" => "i-banners",
                "title" => "بنرها",
                "url" => route('banners.index'),
                'permission'=>Permission::PERMISSION_MANAGE_BANNERS
            ]);
        });
    }
}
