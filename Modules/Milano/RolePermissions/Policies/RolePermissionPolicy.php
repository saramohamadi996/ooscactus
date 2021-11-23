<?php

namespace Milano\RolePermissions\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Milano\RolePermissions\Models\Permission;

class RolePermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can show permission.
     * @param $user
     * @return bool|null
     */
    public function index($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS)) return true;
        return null;
    }

    /**
     * Determine if the given user can create permission.
     * @param $user
     * @return bool|null
     */
    public function create($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS)) return true;
        return null;
    }

    /**
     * Determine if the given user can edit permission.
     * @param $user
     * @return bool|null
     */
    public function edit($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS)) return true;
        return null;
    }

    /**
     * Determine if the given user can delete permission.
     * @param $user
     * @return bool|null
     */
    public function delete($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS)) return true;
        return null;
    }

}
