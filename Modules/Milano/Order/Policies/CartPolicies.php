<?php
namespace Milano\Cart\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;
use Milano\RolePermissions\Models\Permission;

class CartPolicies
{
    use HandlesAuthorization;

    public function order($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_CARTS)) return true;
        return null;
    }
    public function create($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_CARTS)) return true;
        return null;
    }
    public function edit($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_CARTS)) return true;
        return null;
    }
    public function delete($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_CARTS)) return true;
        return null;
    }
}
