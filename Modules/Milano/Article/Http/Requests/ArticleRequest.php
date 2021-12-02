<?php

namespace Milano\Article\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * @var mixed
     */
//    private $category_id;

    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return $rules = [
            'title' => 'nullable|min:3|max:250',
            'slug' => 'nullable|min:3|max:250',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|mimes:jpg,jpeg,png',
            'body' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            "title" => "عنوان مقاله",
            "slug" => "نام پیوند",
            "category_id" => "دسته بندی ",
            "body" => "توضیحات",
            "image" => "تصویر مقاله",
        ];
    }
}

