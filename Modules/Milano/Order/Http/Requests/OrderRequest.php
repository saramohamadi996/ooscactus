<?php
namespace Milano\Order\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }
    public function rules()
    {
        return [
            "name"=>'required|min:3|max:100',
            "mobile"=>'required|numeric',
            "state"=>'required|min:3|max:100',
            "city" => 'required|min:3|max:100',
        ];
    }
    public function attributes()
    {
        return[
            "name"=>"نام",
            "mobile"=>"موبایل",
            "state"=>"استان",
            "city"=>"شهر",
        ];
    }
}
