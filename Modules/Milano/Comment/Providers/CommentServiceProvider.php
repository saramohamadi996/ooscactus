<?php
namespace Milano\Comment\Providers;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Support\ServiceProvider;
use Milano\Comment\Models\Comment;
use Milano\Comment\Policies\CommentPolicy;
use Milano\RolePermissions\Models\Permission;

class CommentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__. '/../Routes/comments_routes.php');
        $this->loadViewsFrom(__DIR__. '/../Resources/Views', 'Comments');
        $this->loadMigrationsFrom(__DIR__. '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__. '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__. '/../Resources/Lang/', "Comments");
        Gate::policy(Comment::class,CommentPolicy::class);
    }

    public function boot()
    {
        config()->set('sidebar.items.comments', [
            "icon" => "i-comments",
            "title" => "نظرات",
            "url" => route('comments.index'),
        'permission'=>Permission::PERMISSION_MANAGE_COMMENTS,
        ]);
    }

}
