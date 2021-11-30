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
use Milano\User\Repositories\Interfaces\LoginRepositoryInterface;
use Milano\User\Repositories\Interfaces\UserRepositoryInterface;
use Milano\User\Repositories\Interfaces\VerifyCodeRepositoryInterface;
use Milano\User\Repositories\LoginRepository;
use Milano\User\Repositories\UserRepository;
use Milano\User\Repositories\VerifyCodeRepository;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        config()->set('auth.providers.users.model', User::class);
        $this->loadFactoriesFrom(__DIR__ . '/../Database/Factories');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/user_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'User');
        $this->loadJsonTranslationsFrom(__DIR__ . "/../Resources/Lang");
        $this->app['router']->pushMiddlewareToGroup('web', StoreUserIp::class);

        DatabaseSeeder::$seeders[] = UsersTableSeeder::class;
        Gate::policy(User::class, UserPolicy::class);
    }

    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(VerifyCodeRepositoryInterface::class, VerifyCodeRepository::class);
        $this->app->bind(LoginRepositoryInterface::class, LoginRepository::class);
        $this->app->booted(function () {
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
