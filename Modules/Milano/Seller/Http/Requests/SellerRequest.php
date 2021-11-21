<?php

namespace Milano\Seller\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return [
            'titre' => 'required|min:3|max:250',
            'title1' => 'required|min:3|max:250',
            'title2' => 'required|min:3|max:250',
            'title3' => 'required|min:3|max:250',
            'title' => 'required|min:3|max:250',
            'head' => 'required|min:3|max:250',
            'head2' => 'required|min:3|max:250',
            'head3' => 'required|min:3|max:250',
            'percent' => 'required|min:3|max:250',
            'price' => 'required|min:9|max:14|numeric',
            'payment' => 'required|email',
            'telegram' => 'required|email',
            'image1' => 'required|mimes:png',
            'image2' => 'required|mimes:png',
            'image3' => 'required|mimes:png',
            'product' => 'required|min:3',
            'standard' => 'required|min:3',
            'rules' => 'required|min:3',
            'body' => 'nullable|min:3',
        ];
    }

    public function attributes()
    {
        return[
            "title1" => "عنوان",
            "title2" => "عنوان",
            "title3" => "عنوان",
            "title" => "عنوان",
            "head1" => "زیر عنوان",
            "head2" => " زیر عنوان",
            "head3" => "زیر عنوان",
            "percent" => "درصد",
            "price" => "قیمت",
            "payment" => "پرداخت",
            "telegram" => "تلگرام",
            "image1" => "تصویر",
            "image2" => "تصویر",
            "image3" => "تصویر",
            "product" => "توضیحات محصول",
            "rules" => "متن قرارداد",
            "standard" => "استانداردهای لازم",
        ];
    }
}
