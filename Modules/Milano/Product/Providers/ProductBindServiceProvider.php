<?php

namespace Milano\Product\Providers;

use Illuminate\Support\ServiceProvider;
use Milano\Product\Repositories\Interfaces\ProductRepositoryInterface;
use Milano\Product\Repositories\ProductRepository;

class ProductBindServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Define your route model bindings
     */
    public function boot()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }
}
