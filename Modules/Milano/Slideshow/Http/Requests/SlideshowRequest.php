<?php
namespace Milano\Slideshow\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideshowRequest extends FormRequest
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
            "title" => "عنوان اسلاید",
            "link" => "لینک اسلاید",
            "image" => "تصویر اسلاید",
        ];
    }
}
