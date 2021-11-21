<?php


namespace Milano\User\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPhoto extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return [
            'userPhoto'=>['required', 'mimes:jps,jpeg,png']
        ];
    }
}
