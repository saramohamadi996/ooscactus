<?php

namespace Milano\Comment\Policies;

use Milano\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function manage($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COMMENTS)) return true;
        return null;
    }

    public function index($user)
    {
        if ($user->hasAnyPermission(Permission::PERMISSION_MANAGE_COMMENTS, Permission::PERMISSION_SELL))
            return true;

        return null;
    }

    public function view($user, $comment)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COMMENTS) ||
            $user->id == $comment->commentable->teacher_id)
            return true;

        return null;
    }
}
