<?php

namespace Milano\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() == true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return string[]
     */
    public function rules()
    {
        return [
            "title"=>'required|unique:categories,title|min:3|max:190',
            "slug" => 'required|min:3|max:190|unique:categories,slug',
            'parent_id'=> 'nullable|exists:categories,id',
        ];
    }

    /**
     * Translate request verification attributes.
     * @return array|string[]
     */
    public function attributes()
    {
        return[
            "title" => "عنوان دسته بندی",
            "slug" => " نام پیوند",
            "parent_id" => "شناسه والد",
        ];
    }
}
