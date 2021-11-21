<?php
namespace Milano\Cart\Providers;
use Illuminate\Support\ServiceProvider;


class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/Carts_routes.php');
//        $this->loadViewsFrom(__DIR__ . "/../Resources/Views", "Carts");
//        $this->loadJsonTranslationsFrom(__DIR__. '/../Resources/Lang');
//        $this->loadTranslationsFrom(__DIR__. '/../Resources/Lang/', "Banners");
//        Gate::policy(Cart::class, CartPolicies::class);
    }

//    public function boot()
//    {
//        config()->set('sidebar.items.carts', [
//            "icon" => "i-orders",
//            "title" => "سفارشات",
//            "url" => url('cart/order'),
//            "permission" => [
//                Permission::PERMISSION_MANAGE_CARTS,
//            ]
//        ]);
//    }
}
