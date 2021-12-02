<?php

namespace Milano\RolePermissions\Repositories;

use Milano\RolePermissions\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * fetch query builder indicator.
     *
     * @return Builder|mixed
     */
    private function fetchQueryBuilder(): Builder
    {
        return Role::query();
    }

    public function getAll(): Collection
    {
        return $this->fetchQueryBuilder()->get();
    }

    /**
     * it returns an instance of banner model according to given id
     * @param int $id
     * @return Role|Builder|Builder[]|Collection|Model
     */
    public function findById($id): Role
    {
        return $this->fetchQueryBuilder()->findOrFail($id);
    }

    public function store(array $value): bool
    {
        $role = new Role();
        $role->name = $value['name'];
        $role->syncPermissions($value['permissions']);
        try {
            $role->save();
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Update the specified resource in storage.
     * @param Role $role
     * @param array $value
     * @return bool
     */
    public function update(Role $role, array $value): bool
    {
        $role->syncPermissions($value['permissions'])->update(['name' => $value['name']]);
        try {
            $role->save();
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return false;
        }
        return true;
    }


    /**
     * Remove the specified resource from storage.
     * @param Role $role
     * @return bool
     * @throws \Exception
     */
    public function delete(Role $role): bool
    {
        try {
            $role->delete();
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return false;
        }
        return true;
    }
}
