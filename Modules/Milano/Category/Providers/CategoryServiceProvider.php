<?php
namespace Milano\Category\Providers;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Support\ServiceProvider;
use Milano\Article\Policies\ArticlePolicy;
use Milano\Category\Models\Category;
use Milano\Category\Repositories\CategoryRepository;
use Milano\Category\Repositories\Interfaces\CategoryRepositoryInterface;
use Milano\RolePermissions\Models\Permission;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * Introducing different parts of the module to Laravel application.
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__. '/../Routes/categories_routes.php');
        $this->loadViewsFrom(__DIR__. '/../Resources/Views', 'Categories');
        $this->loadMigrationsFrom(__DIR__. '/../Database/Migrations');
        Gate::policy(Category::class, ArticlePolicy::class);
    }

    /**
     * Display details of menu items in the sidebar, such as name, icon and url.
     */
    public function boot()
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        $this->app->booted(function(){
            config()->set('sidebar.items.categories', [
                "icon" => "i-categories",
                "title" => "دسته بندی ها",
                "url" => route('categories.index'),
                "permission" => Permission::PERMISSION_MANAGE_CATEGORIES
            ]);
        });
    }

}
