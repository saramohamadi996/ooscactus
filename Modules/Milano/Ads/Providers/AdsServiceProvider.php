<?php
namespace Milano\Ads\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Milano\Ads\Models\Ads;
use Milano\Ads\Policies\AdsPolicy;
use Milano\RolePermissions\Models\Permission;

class AdsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__. '/../Routes/adss_routes.php');
        $this->loadViewsFrom(__DIR__. '/../Resources/Views', 'Adss');
        $this->loadMigrationsFrom(__DIR__. '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__. '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__. '/../Resources/Lang/', "Adss");
        Gate::policy(Ads::class,AdsPolicy::class);
    }

    public function boot()
    {
        config()->set('sidebar.items.adss', [
            "icon" => "i-ads",
            "title" => "تبلیغات",
            "url" => route('adss.index'),
            'permission'=>Permission::PERMISSION_MANAGE_ADSS,
        ]);
    }
}
