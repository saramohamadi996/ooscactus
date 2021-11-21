<?php
namespace Milano\User\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Milano\Common\Responses\AjaxResponses;
use Milano\Product\Models\ImageProduct;
//use Milano\Product\Models\Product;
use Milano\Product\Repositories\ProductRepo;
use Milano\RolePermissions\Models\Role;
use Milano\RolePermissions\Repositories\RoleRepo;
use Milano\User\Http\Requests\AddRoleRequest;
use Milano\User\Http\Requests\UpdateUserPhoto;
use Milano\User\Http\Requests\UpdateUserRequest;
use Milano\User\Repositories\UserRepo;
use Milano\User\Http\Requests\UpdateProfileInformationRequest;

class UserController extends Controller
{
    private $Repo;
    private $roleRepo;
    private $productRepo;
        public function __construct(UserRepo $userRepo, RoleRepo $roleRepo, ProductRepo $productRepo)
    {
        $this->Repo = $userRepo;
        $this->roleRepo = $roleRepo;
        $this->productRepo = $productRepo;
    }

    public function index(Request $request)
    {
        $users = $this->Repo->searchName($request->name)
            ->searchEmail($request->email)
            ->searchMobile($request->mobile)->paginate();
        $roles =  $this->roleRepo->all();
        $this->authorize('index', $users);
        return view("User::Admin.index", compact('users', 'roles'));
    }

    public function edit($userId)
    {
        $roles = $this->roleRepo->all();
        $user = $this->Repo->findById($userId);
        $products = $this->productRepo->getSellers();
        $this->authorize('edit', $user);
        return view("User::Admin.edit", compact('user', 'roles' ,'products'));
    }

    public function update(UpdateUserRequest $request, $userId)
    {
        $user = $this->Repo->findByid($userId);
        $this->authorize('edit', $user);
        return redirect(route('users.index'));
    }

    public function manualVerify($userId)
    {
        $user = $this->Repo->findById($userId);
        $this->authorize('manualVerify', $user);
        $user->markEmailAsVerified();
        return AjaxResponses::SuccessResponse();
    }

    public function addRole(AddRoleRequest $request)
    {
        $user = $this->Repo;
        $user->assignRole($request->role);
        $this->authorize('addRole', $user);
        newFeedback('موفقیت آمیز', " نقش کاربری {$request->role}
         به کاربر {$user->name} داده شد.", 'success');
        return back();
    }

    public function removeRole($userId, $role)
    {
         $user = $this->Repo->findById($userId);
        $user->removeRole($role);
        return AjaxResponses::SuccessResponse();
    }

    public function remove($id)
    {
        $user = $this->Repo->findOrFail($id);
        $this->authorize('removeRole', $user);
        if($user->image){
            Storage::delete('public\\' . $user->image);
            $user->image = null;
            $user->save();
        }
        return back();
    }

    public function profile()
    {
        return view('User::admin.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = $this->Repo->updateProfile($request);
        return back();
    }

    public function updateImage(Request $request)
    {
        $user = $this->Repo->updateImage($request);
        return back();
    }

    public function destroy($userId)
    {
        $user = $this->Repo->findById($userId);
        $this->authorize('delete', $user);
        $user->delete();
        return AjaxResponses::SuccessResponse();
    }
}
