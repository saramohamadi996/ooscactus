<?php
namespace Milano\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Milano\Permissions\Models\Role;
use Milano\Product\Models\Product;
use Illuminate\Validation\Rule;
use Milano\Product\Rules\ValidSeller;
use Milano\User\Models\User;


class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return [
            "name"=>'nullable|min:3|max:190',
            "email"=>'nullable|min:3|max:190|unique:users,email,' . request()->route('user'),
            "username"=>'nullable|min:3|max:190|unique:users,username,' . request()->route('user'),
            "mobile"=>'nullable|unique:users,mobile,' . request()->route('user'),
            "status" => ["nullable", Rule::in(User::$statuses)],
            "image"=> "nullable|mimes:jpg,png,jpeg",
        ];
    }

    public function attributes()
    {
        return[
            "name"=>"نام",
            "email"=>"ایمیل ",
            "username"=>"نام کاربری",
            "mobile"=>"موبایل",
            "status"=>"وضعیت",
            "image"=>"عکس پروفایل",
        ];
    }
}
