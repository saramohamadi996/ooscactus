<?php
namespace Milano\Product\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;
use Milano\RolePermissions\Models\Permission;
use Milano\User\Models\User;

class ProductPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function manage(User $user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS);
    }

    public function index($user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS) ||
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_PRODUCTS);
    }
    public function create($user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS) ||
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_PRODUCTS);
    }

    public function edit($user, $product)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS)) return true;
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS) && $product->seller_id == $user->id;
    }

    public function delete($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS)) return true;
        return null;
    }

    public function change_confirmation_status($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS)) return true;
        return null;
    }
}

