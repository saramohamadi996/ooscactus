<?php

namespace Milano\Article\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Milano\RolePermissions\Models\Permission;
use Milano\User\Models\User;

class CouponPolicy
{
    use HandlesAuthorization;

    public function index($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COUPONS)) return true;
        return null;
    }

    public function create($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COUPONS)) return true;
        return null;
    }

    public function edit($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COUPONS)) return true;
        return null;
    }

    public function delete($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COUPONS)) return true;
        return null;
    }

}
