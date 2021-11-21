<?php

namespace Milano\Comment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return [
            'title'=>'required|max:190',
            'slug'=>'required|max:190',
            'parent_id'=> 'nullable|exists:categories,id',
        ];
    }

    public function attributes()
    {
        return[
            "title" => " عنوان نظر",
            "slug" => " نام پیوند",
            "parent_id" => "شناسه والد",
        ];
    }
}
