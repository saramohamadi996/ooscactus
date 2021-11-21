<?php
namespace Milano\Category\Providers;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Support\ServiceProvider;
use Milano\Category\Models\Category;
use Milano\Category\Policies\ArticlePolicy;
use Milano\RolePermissions\Models\Permission;

class CategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__. '/../Routes/categories_routes.php');
        $this->loadViewsFrom(__DIR__. '/../Resources/Views', 'Categories');
        $this->loadMigrationsFrom(__DIR__. '/../Database/Migrations');
        Gate::policy(Category::class, ArticlePolicy::class);
    }

    public function boot()
    {
//        $this->app->booted(function(){
            config()->set('sidebar.items.categories', [
                "icon" => "i-categories",
                "title" => "دسته بندی ها",
                "url" => route('categories.index'),
                "permission" => Permission::PERMISSION_MANAGE_CATEGORIES
            ]);
//        });
    }

}
