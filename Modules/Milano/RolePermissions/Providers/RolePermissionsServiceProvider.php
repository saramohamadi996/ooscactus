<?php

namespace Milano\RolePermissions\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Gate;
use Milano\RolePermissions\Database\Seeds\RolePermissionTableSeeder;
use Milano\RolePermissions\Models\Permission;
use Illuminate\Support\ServiceProvider;
use Milano\RolePermissions\Models\Role;
use  Milano\RolePermissions\Policies\RolePermissionPolicy;
use Milano\RolePermissions\Repositories\Interfaces\PermissionRepositoryInterface;
use Milano\RolePermissions\Repositories\Interfaces\RoleRepositoryInterface;
use Milano\RolePermissions\Repositories\PermissionRepository;
use Milano\RolePermissions\Repositories\RoleRepository;

class RolePermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * Introducing different parts of the module to Laravel application.
     */
    public function register()
    {
        Gate::before(function ($user) {
            return $user->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN) ? true : null;
        });
        $this->loadRoutesFrom(__DIR__ . '/../Routes/role_permission_routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views/', 'RolePermissions');
        $this->loadJsonTranslationsFrom(__DIR__ . "/../Resources/Lang");
        DatabaseSeeder::$seeders[] = RolePermissionTableSeeder::class;
        Gate::policy(Role::class, RolePermissionPolicy::class);

    }

    /**
     * Display details of menu items in the sidebar, such as name, icon and url.
     */
    public function boot()
    {
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->booted(function () {
            config()->set('sidebar.items.role-permissions', [
                "icon" => "i-role-permissions",
                "title" => "نقش های کاربری",
                "url" => route('role-permissions.index'),
                'permission' => Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS
            ]);
        });
    }
}
