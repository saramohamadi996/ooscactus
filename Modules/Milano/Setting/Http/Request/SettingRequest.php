<?php
namespace Milano\Setting\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return [
            'title' => 'required|min:3|max:250',
            'mobile' => 'required|min:9|max:14|numeric',
            'email' => 'required|email',
            'address' => 'required',
            'logo' => 'required|mimes:png',
            'symbol' => 'required|mimes:png',
            'website' => 'nullable|min:3',
            'telegram' => 'nullable|min:3',
            'whatsapp' => 'nullable|min:3',
            'body' => 'nullable|min:3',
        ];
    }

    public function attributes()
    {
        return[
            "title"=>"عنوان",
            "mobile" =>"موبایل",
            "email" => "ایمیل",
            "address" =>"آدرس",
            "logo" =>"لوگو",
            "symbol" =>"نماد",
            "website" =>"وب سایت",
            "telegram" =>"تلگرام",
            "whatsapp" =>"واتس آپ",
            "body" =>" توضیحات",
        ];
    }
}
