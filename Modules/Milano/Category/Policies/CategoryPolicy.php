<?php


namespace Milano\Category\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;
use Milano\RolePermissions\Models\Permission;
use Milano\User\Models\User;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
    }
}
