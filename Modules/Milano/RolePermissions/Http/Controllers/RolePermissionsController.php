<?php

namespace Milano\RolePermissions\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Milano\Common\Responses\AjaxResponses;
use Milano\RolePermissions\Http\Requests\RoleRequest;
use Milano\RolePermissions\Http\Requests\RoleUpdateRequest;
use Milano\RolePermissions\Repositories\PermissionRepo;
use Milano\RolePermissions\Models\Role;
use Milano\RolePermissions\Repositories\RoleRepo;

class RolePermissionsController extends  Controller
{
    private $roleRepo;
    private $permissionRepo;
    public function __construct(RoleRepo $roleRepo, PermissionRepo $permissionRepo)
    {
        $this->roleRepo = $roleRepo;
        $this->permissionRepo = $permissionRepo;
    }
    public function index()
    {
        $roles = $this->roleRepo->all();
        $permissions = $this->permissionRepo->all();
        $this->authorize('index', $roles);
        return view( 'RolePermissions::index' , compact('roles', 'permissions'));
    }

    public function store(RoleRequest $request)
    {
        $this->roleRepo->create($request);
        return redirect(route('role-permissions.index'));
    }

    public function edit( $roleId)
    {
       $role = $this->roleRepo->findById($roleId);
        $permissions = $this->permissionRepo->all();
        $this->authorize('edit', $role);
        return view( 'RolePermissions::edit' , compact('role', 'permissions'));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        $role = $this->roleRepo->update($id, $request);
        $this->authorize('edit', $role);
        return redirect(route('role-permissions.index'));
    }

    public function destroy($roleId)
    {
        $this->roleRepo->delete($roleId);
        $this->authorize('delete', $roles);
        return AjaxResponses::SuccessResponse();
    }
}
