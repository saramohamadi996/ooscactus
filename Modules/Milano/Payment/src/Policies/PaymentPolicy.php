<?php

namespace Milano\Payments\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Milano\RolePermissions\Models\Permission;

class PaymentPolicy
{
    use HandlesAuthorization;

    public function index($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_PAYMENTS)) return true;
        return null;
    }
    public function create($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_PAYMENTS)) return true;
        return null;
    }
    public function edit($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_PAYMENTS)) return true;
        return null;
    }
    public function delete($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_PAYMENTS)) return true;
        return null;
    }
}
