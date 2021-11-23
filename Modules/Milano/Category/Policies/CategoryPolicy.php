<?php

namespace Milano\Category\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Milano\RolePermissions\Models\Permission;
use Milano\User\Models\User;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can manage and create categories.
     * @param User $user
     * @return bool
     */
    public function manage(User $user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
    }

    /**
     * Determine if the given user can edit categories.
     * @param User $user
     * @return bool
     */
    public function edit(User $user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
    }

    /**
     * Determine if the given user can delete categories.
     * @param User $user
     * @return bool
     */
    public function destroy(User $user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
    }
}
