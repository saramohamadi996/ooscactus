<?php

namespace Milano\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return [
            "title"=>'required|unique:categories,title|min:3|max:190',
            "slug" => 'required|min:3|max:190|unique:categories,slug',
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
