<?php

namespace Milano\Article\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Milano\Article\Models\Article;
use Milano\Article\Policies\ArticlePolicy;
use Milano\RolePermissions\Models\Permission;

class ArticleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__. '/../Routes/articles_routes.php');
        $this->loadViewsFrom(__DIR__. '/../Resources/Views', 'Articles');
        $this->loadMigrationsFrom(__DIR__. '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__. '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__. '/../Resources/Lang/', "Articles");
        Gate::policy(Article::class,ArticlePolicy::class);
    }

    public function boot()
    {
        config()->set('sidebar.items.articles', [
            "icon" => "i-articles",
            "title" => "مقالات",
            "url" => route('articles.index'),
            'permission'=>Permission::PERMISSION_MANAGE_ARTICLES,
        ]);
    }
}
