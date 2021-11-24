<?php

namespace Milano\Product\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Milano\RolePermissions\Models\Permission;
use Milano\User\Models\User;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can manage product.
     * @param $user
     * @return bool|null
     */
    public function manage(User $user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS);
    }

    /**
     * Determine if the given user can show product.
     * @param $user
     * @return bool|null
     */
    public function index($user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS) ||
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_PRODUCTS);
    }

    /**
     * Determine if the given user can create product.
     * @param $user
     * @return bool|null
     */
    public function create($user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS) ||
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_PRODUCTS);
    }

    /**
     * Determine if the given user can edit product.
     * @param $user
     * @return bool|null
     */
    public function edit($user, $product)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS)) return true;
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS) && $product->seller_id == $user->id;
    }

    /**
     * Determine if the given user can delete product.
     * @param $user
     * @return bool|null
     */
    public function delete($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS)) return true;
        return null;
    }

    /**
     * Determine if the given user can change confirmation status product.
     * @param $user
     * @return bool|null
     */
    public function change_confirmation_status($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_PRODUCTS)) return true;
        return null;
    }
}

