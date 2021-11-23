<?php

namespace Milano\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return [
            "title"=>'nullable|unique:categories,title|min:3|max:190',
            "slug" => 'nullable|min:3|max:190|unique:categories,slug',
            'parent_id'=> 'nullable|exists:categories,id',
        ];
    }

    public function attributes()
    {
        return[
            "title" => "عنوان دسته بندی",
            "slug" => " نام پیوند",
            "parent_id" => "شناسه والد",
        ];
    }
}
