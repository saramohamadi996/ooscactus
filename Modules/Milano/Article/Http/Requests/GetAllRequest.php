<?php

namespace Milano\Article\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetAllRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return $rules = [
            'title' => 'nullable|min:3|max:250',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    public function attributes()
    {
        return [
            "title" => "عنوان مقاله",
            "category_id" => "دسته بندی ",
        ];
    }
}

