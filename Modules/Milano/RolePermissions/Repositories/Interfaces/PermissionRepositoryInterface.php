<?php

namespace Milano\RolePermissions\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

interface PermissionRepositoryInterface
{
    /**
     * Get the value from the database.
     * @return Collection|Permission[]
     */
    public function getAll(): Collection;
}
