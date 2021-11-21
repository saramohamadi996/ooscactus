<?php
namespace Milano\Setting\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;
use Milano\RolePermissions\Models\Permission;

class SettingPolicies
{
    use HandlesAuthorization;

    public function index($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_SETTINGS)) return true;
        return null;
    }
    public function create($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_SETTINGS)) return true;
        return null;
    }
    public function edit($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_SETTINGS)) return true;
        return null;
    }
    public function delete($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_SETTINGS)) return true;
        return null;
    }
}
