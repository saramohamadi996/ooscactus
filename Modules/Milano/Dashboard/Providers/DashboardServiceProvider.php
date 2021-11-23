<?php

namespace Milano\Dashboard\Providers;

use \Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * Introducing different parts of the module to Laravel application.
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/dashboard_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Dashboard');
        $this->mergeConfigFrom(__DIR__ . '/../Config/sidebar.php', 'sidebar');
    }

    /**
     * Display details of menu items in the sidebar, such as name, icon and url.
     */
    public function boot()
    {
        config()->set('sidebar.items.dashboard', [
            "icon" => "i-dashboard",
            "title" => "پیشخوان",
            "url" => url('dashboard')
        ]);
    }

}
