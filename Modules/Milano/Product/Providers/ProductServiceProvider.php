<?php

namespace Milano\Product\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Milano\Product\Models\Product;
use Milano\Product\Policies\ProductPolicy;
use Milano\Product\Repositories\Interfaces\ProductRepositoryInterface;
use Milano\Product\Repositories\ProductRepository;
use Milano\RolePermissions\Models\Permission;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * Introducing different parts of the module to Laravel application.
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/Products_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Products');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang/', "Products");
        Gate::policy(Product::class, ProductPolicy::class);
    }

    /**
     * Display details of menu items in the sidebar, such as name, icon and url.
     */
    public function boot()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        config()->set('sidebar.items.products', [
            "icon" => "i-courses",
            "title" => "محصولات",
            "url" => route('products.index'),
            "permission" => [
                Permission::PERMISSION_MANAGE_PRODUCTS,
                Permission::PERMISSION_MANAGE_OWN_PRODUCTS
            ]
        ]);
    }
}
