<?php

namespace Milano\Article\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        $rules =  [
            'title' => 'required|min:3|max:250',
            'slug' => 'required|min:3|max:250',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'required|mimes:jpg,jpeg,png',
            'body' => 'nullable',
        ];

        if(request()->method == 'PATCH'){
            $rules['image'] = 'mimes:jpg,jpeg,png';
        }
        return $rules;
    }

    public function attributes()
    {
        return[
            "title" => "عنوان مقاله",
            "slug" => "نام پیوند",
            "category_id" => "دسته بندی ",
            "body" => "توضیحات",
            "image" => "تصویر مقاله",
        ];
    }
}

