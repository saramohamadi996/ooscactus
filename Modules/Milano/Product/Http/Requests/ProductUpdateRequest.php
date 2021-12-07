<?php

namespace Milano\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Milano\Product\Models\Product;
use Illuminate\Validation\Rule;
use Milano\Product\Rules\ValidSeller;

class ProductUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return $rules = [
            "title" => [Rule::unique('products')->whereNull('title'), 'min:3|max:190|string'],
            "slug" => [Rule::unique('products')->whereNull('slug'), 'min:3|max:190|string'],
            "priority" => [Rule::unique('products')->whereNull('priority'), 'nullable|min:1|max:100000|numeric'],
            "code_product" => [Rule::unique('products')->whereNull('code_product'), 'min:3|max:190|string'],
            "stock" => 'nullable|numeric',
            "meta_description" => 'nullable|min:3|max:190',
            "price" => 'nullable|numeric|min:0|max:1000000000',
            "percent" => 'nullable|numeric|min:0|max:100',
            "seller_id" => ['nullable', 'exists:users,id', new ValidSeller()],
            "category_id" => 'nullable|exists:categories,id',
            "image[]" => "nullable|mimes:jpg,png,jpeg",
            "status" => "nullable|bool",
            "is_enabled" => "nullable|bool",
        ];
    }


    public function attributes()
    {
        return [
            "title" => "عنوان",
            "slug" => "عنوان انگلیسی",
            "priority" => "ردیف محصول",
            "price" => "قیمت",
            "stock" => "موجودی",
            "code_product" => "کد محصول",
            "percent" => "درصد فروشنده",
            "seller_id" => "فروشنده",
            "category_id" => "دسته بندی",
            "body" => "توضیحات",
            "image" => "تصویر محصول",
            "status" => "وضعیت",
            "is_enabled" => "وضعیت تایید",
        ];
    }
}
