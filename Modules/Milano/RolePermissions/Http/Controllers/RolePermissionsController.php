<?php

namespace Milano\RolePermissions\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Milano\RolePermissions\Http\Requests\RoleRequest;
use Milano\RolePermissions\Http\Requests\RoleUpdateRequest;
use Milano\RolePermissions\Models\Role;
use Milano\RolePermissions\Repositories\Interfaces\PermissionRepositoryInterface;
use Milano\RolePermissions\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Access\AuthorizationException;

class RolePermissionsController extends Controller
{
    /**
     * The category repository instance.
     * @var RoleRepositoryInterface
     */
    protected RoleRepositoryInterface $role_repository;

    /**
     * The category repository instance.
     * @var PermissionRepositoryInterface
     */
    protected PermissionRepositoryInterface $permission_repository;

    /**
     * RolePermissionsController constructor.
     * @param RoleRepositoryInterface $role_repository
     * @param PermissionRepositoryInterface $permission_repository
     */
    public function __construct(RoleRepositoryInterface $role_repository,
                                PermissionRepositoryInterface $permission_repository)
    {
        $this->role_repository = $role_repository;
        $this->permission_repository = $permission_repository;
    }

    /**
     * Display a listing of the resource.
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index()
    {
        $roles = $this->role_repository->getAll();
        $permissions = $this->permission_repository->getAll();
        $this->authorize('index', $roles);
        return view('RolePermissions::index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return View
     * @throws AuthorizationException
     */
    public function edit($id): View
    {
        $this->authorize('edit', Role::class);
        $role = $this->role_repository->findById($id);
        $permissions = $this->permission_repository->getAll();
        return view('RolePermissions::edit', compact('role', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param RoleRequest $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $input = $request->only(['name', 'permissions']);
        $result = $this->role_repository->create($input);
        if (!$result) {
            return redirect()->back()->with('error', 'عملیات ذخیره سازی با شکست مواجه شد.');
        }
        return redirect()->route('role-permissions.index')
            ->with('success', 'عملیات بروزرسانی با موفقیت انجام شد.');
    }

    /**
     * Update the specified resource in storage.
     * @param $id
     * @param RoleUpdateRequest $request
     * @return RedirectResponse
     */
    public function update($id, RoleUpdateRequest $request): RedirectResponse
    {
        $role = $this->role_repository->findById($id);
        $input = $request->only(['name', 'permissions']);
        $result = $this->role_repository->update($role, $input);
        if (!$result) {
            return redirect()->back()->with('error', 'عملیات بروزرسانی با شکست مواجه شد.');
        }
        return redirect()->route('role-permissions.index')->with('success', 'عملیات بروزرسانی با موفقیت انجام شد.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('destroy', Role::class);
        $role = $this->role_repository->findById($id);
        $result = $this->role_repository->delete($role);
        if (!$result) {
            return redirect()->back()->with('error', 'عملیات حذف با شکست مواجه شد.');
        }
        return redirect()->back()->with('success', 'عملیات حذف با موفقیت شد.');
    }
}
