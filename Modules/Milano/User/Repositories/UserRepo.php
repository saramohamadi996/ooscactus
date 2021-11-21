<?php
namespace Milano\User\Repositories;
use Illuminate\Support\Facades\Storage;
use Milano\RolePermissions\Models\Permission;
use Milano\User\Models\User;

class UserRepo
{
    private $query;
    public function __construct()
    {
        $this->query = User::query();
    }

    public function findByEmail($email)
    {
        return User::query()->where('email', $email)->firstOrFail();
    }

    public function getSellers()
    {
        return User::permission(Permission::PERMISSION_SELL)->get();
    }

//    public function getSeller()
//    {
//        return User::where('seller_id' , $userId)->get();
//    }

    public function getUsers()
    {
        return User::all();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

      public function searchName($name)
    {
        if (!is_null($name)) {
            $this->query->where("name", "like", "%" .  $name . "%");
        }return $this;
    }

    public function searchEmail($email)
    {
        if (!is_null($email)) {
            $this->query->where("email", "like", "%" .  $email . "%");
        }return $this;
    }

    public function searchMobile($mobile)
    {
        if (!is_null($mobile)) {
            $this->query->where("mobile", "like", "%" .  $mobile . "%");
        }return $this;
    }

    public function paginate()
    {
        return $this->query->latest()->paginate();
    }

    public function update($userId, $values )
    {
        $update = [
            'name' => $values->name,
            'email' => $values->email,
            'mobile' => $values->mobile,
            'username' => $values->username,
            'headline' => $values->headline,
            'status' => $values->status,
            'bio' => $values->bio,
            'image' => $path ?? auth()->user()->image,
        ];
        if (! is_null($values->password)) {
            $update['password'] = bcrypt($values->password);
        }
        $user = User::find($userId);
        $user->syncRoles([]);
        if ($values['role'])
            $user->assignRole($values['role']);
        return User::where('id', $userId)->update($update);
    }

    public function updateProfile($request)
    {
        if($request->hasFile('image')){
            $imagePath = $request->file('image');
            $fileName  = $imagePath->getClientOriginalName();
            $dir = 'users';
            $path = $imagePath->storeAs($dir , $fileName, 'public');
            if(auth()->user()->image){
                Storage::delete('public\\'. auth()->user()->image);
            }
        }
        auth()->user()->name = $request->name;
        if(auth()->user()->email != $request->email){
            auth()->user()->email = $request->email;
            auth()->user()->email_verified_at = null;
        }
        if (auth()->user()->hasPermissionTo(Permission::PERMISSION_SELL)) {
            auth()->user()->card_number = $request->card_number;
            auth()->user()->shaba = $request->shaba;
            auth()->user()->headline = $request->headline;
            auth()->user()->username = $request->username;
            auth()->user()->image =  $path ?? auth()->user()->image;
        }
        if($request->password){
            auth()->user()->password = bcrypt($request->password);
        }
        auth()->user()->save();
    }

    public function updateImage($request)
    {
        if($request->hasFile('image')){
            $imagePath = $request->file('image');
            $fileName  = $imagePath->getClientOriginalName();
            $dir = 'users';
            $path = $imagePath->storeAs($dir , $fileName, 'public');
            if(auth()->user()->image){
                Storage::delete('public\\'. auth()->user()->image);
            }
        }
        auth()->user()->image = $path ?? auth()->user()->image;
        auth()->user()->save();
    }
}
