<?php
namespace Milano\Setting\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Milano\RolePermissions\Models\Permission;
use Milano\Setting\Models\Setting;
use Milano\Setting\Policies\SettingPolicies;

class SettingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__. '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__. '/../Resources/Views', 'Settings');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/settings_routes.php');
        $this->loadJsonTranslationsFrom(__DIR__. '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__. '/../Resources/Lang/', "Settings");
        Gate::policy(Setting::class,SettingPolicies::class);
    }

    public function boot()
    {
        config()->set('sidebar.items.settings', [
            "icon" => "i-settings",
            "title" => "تنظیمات",
            "url" => route('settings.index'),
            'permission'=>Permission::PERMISSION_MANAGE_SETTINGS,

        ]);
    }
}
