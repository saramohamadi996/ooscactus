<?php
namespace Milano\RolePermissions\Database\Seeds;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionTableSeeder extends Seeder
{
    public function run()
    {
        foreach (\Milano\RolePermissions\Models\Permission::$permissions as $permission){
            Permission::findOrCreate($permission);
        }
        foreach (\Milano\RolePermissions\Models\Role::$roles as $name =>$permissions){
            Role::findOrCreate($name)->givePermissionTo($permissions);
        }
    }
}
