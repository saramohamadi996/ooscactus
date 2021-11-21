<?php
namespace Milano\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Milano\RolePermissions\Models\Permission;
use Milano\User\Rules\ValidPassword;

class UpdateProfileInformationRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        $rules = [
            "name" => 'required|min:3|max:190',
            "email" => 'required|email|min:3|max:190|unique:users,email,' . auth()->id(),
            "username" => 'nullable|min:3|max:190|unique:users,username,' .  auth()->id(),
            "mobile" => 'nullable|unique:users,mobile,' . auth()->id(),
            'password' => ['nullable', new ValidPassword()]
        ];

        if (auth()->user()->hasPermissionTo(Permission::PERMISSION_SELL)) {
            $rules += [
                "card_number" => 'required|string|size:16',
                "shaba" => 'required|size:24',
                "headline" => 'required|min:3|max:60',
                "bio" => 'required',
            ];
            $rules['username'] = 'required|min:3|max:190|unique:users,username,' .  auth()->id();
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'shaba' => 'شماره شبای بانکی',
            'card_number' => 'شماره کارت بانکی',
            'username' => 'نام کاربری',
            'headline' => 'عنوان',
            'bio' => 'بیو',
            "password" => 'رمز عبور جدید',
            "mobile" => "موبایل",
        ];
    }
}
