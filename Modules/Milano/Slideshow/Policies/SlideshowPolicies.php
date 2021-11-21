<?php

namespace Milano\Slideshow\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Milano\RolePermissions\Models\Permission;

class SlideshowPolicies
{
    use HandlesAuthorization;

    public function index($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_SLIDESHOWS)) return true;
        return null;
    }
    public function create($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_SLIDESHOWS)) return true;
        return null;
    }
    public function edit($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_SLIDESHOWS)) return true;
        return null;
    }
    public function delete($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_SLIDESHOWS)) return true;
        return null;
    }
}
