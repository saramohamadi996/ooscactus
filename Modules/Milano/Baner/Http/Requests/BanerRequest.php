<?php
namespace Milano\Baner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BanerRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        $rules =  [
            'title' => 'required|min:3|max:250',
            'link' => 'required|min:3|max:250',
            'image' => 'required|mimes:jpg,jpeg,png',
        ];
        if(request()->method == 'PATCH'){
            $rules['image'] = 'mimes:jpg,jpeg,png';
        }
        return $rules;
    }

    public function attributes()
    {
        return[
            "title" => "عنوان بنر",
            "link" => " لینک بنر",
            "image" => " تصویر بنر",
        ];
    }
}
