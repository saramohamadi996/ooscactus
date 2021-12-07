<?php

namespace Milano\Article\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Milano\Article\Models\Article;
use Milano\Article\Policies\ArticlePolicy;
use Milano\Article\Repositories\ArticleRepository;
use Milano\Article\Repositories\Interfaces\ArticleRepositoryInterface;
use Milano\RolePermissions\Models\Permission;

class ArticleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * Introducing different parts of the module to Laravel application.
     */
    public function register():void
    {
        $this->loadRoutesFrom(__DIR__. '/../Routes/articles_routes.php');
        $this->loadViewsFrom(__DIR__. '/../Resources/Views', 'Articles');
        $this->loadMigrationsFrom(__DIR__. '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__. '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__. '/../Resources/Lang/', "Articles");
        Gate::policy(Article::class,ArticlePolicy::class);
    }

    /**
     * Display details of menu items in the sidebar, such as name, icon and url.
     */
    public function boot():void
    {
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        config()->set('sidebar.items.articles', [
            "icon" => "i-articles",
            "title" => "مقالات",
            "url" => route('articles.index'),
            'permission'=>Permission::PERMISSION_MANAGE_ARTICLES,
        ]);
    }
}
