<?php

namespace Milano\Article\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleStoreRequest extends FormRequest
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
        return $rules = [
            'title' => 'required|min:3|max:250',
            'slug' => 'required|min:3|max:250',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|mimes:jpg,jpeg,png',
            'body' => 'nullable|min:3|string',
        ];
    }

    /**
     * Translate request verification attributes.
     * @return array|string[]
     */
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

