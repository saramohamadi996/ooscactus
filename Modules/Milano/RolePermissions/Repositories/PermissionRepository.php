<?php

namespace Milano\RolePermissions\Repositories;

use Milano\RolePermissions\Repositories\Interfaces\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

class PermissionRepository implements PermissionRepositoryInterface
{
    /**
     * Get the value from the database.
     * @return Collection|Permission[]
     */
    public function getAll(): Collection
    {
        return Permission::all();
    }

}
