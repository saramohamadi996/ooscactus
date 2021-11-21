<?php

namespace Milano\User\Providers;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Milano\User\Database\Seeds\UsersTableSeeder;
use Milano\User\Http\Middleware\StoreUserIp;
use Milano\User\Models\User;
use Milano\User\Policies\UserPolicy;
use Milano\RolePermissions\Models\Permission;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        config()->set('auth.providers.users.model' , User::class);
        $this->loadFactoriesFrom(__DIR__ . '/../Database/Factories');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/user_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views' , 'User');
        $this->loadJsonTranslationsFrom(__DIR__. "/../Resources/Lang");
        $this->app['router']->pushMiddlewareToGroup('web', StoreUserIp::class);

        DatabaseSeeder::$seeders[] = UsersTableSeeder::class;
        Gate::policy(User::class, UserPolicy::class);
    }

    public function boot()
    {
        $this->app->booted(function(){
            config()->set('sidebar.items.users', [
                "icon" => "i-users",
                "title" => "کاربران",
                "url" => route('users.index'),
                "permission" => Permission::PERMISSION_MANAGE_USERS
            ]);
        });
            config()->set('sidebar.items.usersInformation', [
                "icon" => "i-user__inforamtion",
            "title" => "اطلاعات کاربری",
            "url" => route('users.profile'),
        ]);
    }
}
