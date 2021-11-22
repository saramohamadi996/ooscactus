<?php

namespace Milano\Category\Providers;

use Illuminate\Support\ServiceProvider;
use Milano\Category\Repositories\CategoryRepository;
use Milano\Category\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryBindServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {

    }

    /**
     * Define your route model bindings
     */
    public function boot()
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }
}
