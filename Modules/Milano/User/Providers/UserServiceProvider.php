<?php

namespace Milano\User\Providers;

use Database\Seeders\DatabaseSeeder;
use Milano\RolePermissions\Models\Permission;
use Milano\User\Database\Seeds\UsersTableSeeder;
use Milano\User\Http\Middleware\StoreUserIp;
use Milano\User\Models\User;
use Milano\User\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Milano\User\Repositories\Interfaces\UserRepositoryInterface;
use Milano\User\Repositories\UserRepository;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/user_routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadFactoriesFrom(__DIR__ . '/../Database/Factories');
        $this->loadViewsFrom( __DIR__ . '/../Resources/Views', 'User');
        $this->loadJsonTranslationsFrom(__DIR__ . "/../Resources/Lang");
        $this->app['router']->pushMiddlewareToGroup('web', StoreUserIp::class);

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'Milano\User\Database\Factories\\' . class_basename($modelName) .'Factory' ;
        });

        config()->set('auth.providers.users.model', User::class);
        Gate::policy(User::class, UserPolicy::class);
        DatabaseSeeder::$seeders[] = UsersTableSeeder::class;
    }
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        config()->set('sidebar.items.users', [
            "icon" => "i-users",
            "title" => "کاربران",
            "url" => route('users.index'),
            "permission" => Permission::PERMISSION_MANAGE_USERS
        ]);

        config()->set('sidebar.items.usersInformation', [
            "icon" => "i-user__inforamtion",
            "title" => "اطلاعات کاربری",
            "url" => route('users.profile')
        ]);

    }
}
