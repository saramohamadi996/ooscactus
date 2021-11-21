<?php
namespace Milano\Order\Providers;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/orders_routes.php');
        $this->loadViewsFrom(__DIR__ . "/../Resources/Views", "orders");
        $this->loadJsonTranslationsFrom(__DIR__. '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__. '/../Resources/Lang/', "orders");
    }

    public function boot()
    {
        config()->set('sidebar.items.carts', [
            "icon" => "i-orders",
            "title" => "سفارشات",
            "url" => route('orders.index'),
        ]);
    }
}
