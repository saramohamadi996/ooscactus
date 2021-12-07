<?php

namespace Milano\Article\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Milano\RolePermissions\Models\Permission;
use Milano\User\Models\User;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can manage product.
     * @param User $user
     * @return bool|null
     */
    public function index(User $user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ARTICLES)) return true;
        return null;
    }

    /**
     * Determine if the given user can show product.
     * @param User $user
     * @return bool|null
     */
    public function create(User $user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ARTICLES)) return true;
        return null;
    }

    /**
     * Determine if the given user can edit product.
     * @param User $user
     * @return bool|null
     */
    public function edit(User $user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ARTICLES)) return true;
        return null;
    }

    /**
     * Determine if the given user can delete product.
     * @param User $user
     * @return bool|null
     */
    public function delete(User $user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ARTICLES)) return true;
        return null;
    }
}
