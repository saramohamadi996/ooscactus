<?php
namespace Milano\RolePermissions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return [
            "name" => "required|min:3|unique:roles,name",
            "permissions" => 'required|array|min:1'
           ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام مجوز',
            'permissions' => 'مجوزها'
        ];
    }
}
