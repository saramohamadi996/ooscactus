<?php

namespace Milano\Common\Providers;

use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * Introducing different parts of the module to Laravel application.
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__ . "/../Resources", "Common");
    }

    /**
     * Display details of menu items in the sidebar, such as name, icon and url.
     */
    public function boot()
    {
        //
    }
}
