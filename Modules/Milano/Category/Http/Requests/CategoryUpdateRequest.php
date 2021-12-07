<?php

namespace Milano\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends FormRequest
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
            "title" => [Rule::unique('categories')->whereNull('title'), 'min:3|max:190|string'],
            "slug" => [Rule::unique('categories')->whereNull('slug'), 'min:3|max:190|string'],
            'parent_id'=> 'nullable|exists:categories,id',
        ];
    }

    /**
     *  Translate request verification attributes.
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
