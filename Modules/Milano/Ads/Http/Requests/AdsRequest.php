<?php
namespace Milano\Ads\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdsRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        $rules = [

            'title' => 'required|min:3|max:250',
            'link' => 'required|min:3|max:250',
            'ads' => 'required',
            'page' => 'required',
            'opening' => 'required',
            "start_at" => 'required',
            "expired_at" => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
        ];
        if (request()->method == 'PATCH') {
            $rules['image'] = 'mimes:jpg,jpeg,png';
        }
        return $rules;
    }

    public function attributes()
    {
        return[
            "title"=>"عنوان تبلیغ",
            "page"=>"صفحه مورد نظر",
            "ads"=>"نوع تبلیغ",
            "expire_date"=>"تاریخ انقضاء",
            "link"=>"لینک تبلیغ",
            "opening"=>"محدودیت باز شدن",
            "image"=>"تصویر تبلیغ",
        ];
    }
}
