<?php

namespace Milano\RolePermissions\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    /**
     * Get the value from the database.
     * @param $id
     * @return Collection|Role[]
     */
    public function getAll(): Collection;

    /**
     * find by id the record with the given id.
     * @param int $id
     * @return Builder|Role
     */
    public function findById($id): Role;

    /**
     * Store a newly created resource in storage.
     * @param array $value
     * @return bool
     */
    public function store(array $value): bool;

    /**
     * Update the specified resource in storage.
     * @param array $value
     * @param Role $role
     * @return bool
     */
    public function update(Role $role, array $value): bool;

    /**
     * Remove the specified resource from storage.
     * @param Role $role
     * @return bool
     */
    public function delete(Role $role): bool;
}
