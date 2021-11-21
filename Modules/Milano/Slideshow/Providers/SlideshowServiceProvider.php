<?php
namespace Milano\Slideshow\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Milano\Slideshow\Models\Slideshow;
use Milano\Slideshow\Policies\SlideshowPolicies;
use Milano\RolePermissions\Models\Permission;

class SlideshowServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/slideshows_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Slideshows');
        $this->loadJsonTranslationsFrom(__DIR__. '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__. '/../Resources/Lang/', "Slideshows");
        Gate:policy(Slideshow::class, SlideshowPolicies::class);
    }

    public function boot()
    {
        $this->app->booted(function(){
            config()->set('sidebar.items.slideshows', [
                "icon" => "i-slideshow",
                "title" => "اسلایدشو",
                "url" => route('slideshows.index'),
                'permission'=>Permission::PERMISSION_MANAGE_SLIDESHOWS
            ]);
        });
    }
}
