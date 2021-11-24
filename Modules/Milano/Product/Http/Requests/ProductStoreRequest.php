<?php
namespace Milano\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Milano\Product\Models\Product;
use Illuminate\Validation\Rule;
use Milano\Product\Rules\ValidSeller;

class ProductStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        $rules = [
            "image"=>"nullable|mimes:jpg,png,jpeg",
            "title"=>'nullable|unique:products,title|min:3|max:190',
//            "code_product"=>'nullable|unique:products,code_product',
            "stock"=>'nullable|numeric',
            "meta_description"=>'nullable|min:3|max:190',
//            "slug" => 'nullable|min:3|max:190|unique:products,slug',
            "priority"=>'nullable|unique:products,priority||numeric|min:0',
            "price"=>'nullable|numeric|min:0|max:1000000000',
            "percent"=>'nullable|numeric|min:0|max:100',
            "seller_id"=>['nullable','exists:users,id', new ValidSeller()],
            "status" => ["nullable", Rule::in(Product::$statuses)],
            "category_id"=>'nullable|exists:categories,id',
//            "image[]"=> "nullable|mimes:jpg,png,jpeg",
        ];

        if (request()->method === 'PATCH'){
//            $rules['image[]'] = "nullable|mimes:jpg,png,jpeg";
            $rules['slug'] = 'nullable||min:3|max:190|unique:products,slug' . request()->route('product');
        }
        return $rules;
    }

//if (request()->method === 'PATCH') {
//$rules['image'] = "nullable|mimes:jpg,png,jpeg";
//$rules['slug'] = 'required|min:3|max:190|unique:courses,slug,' . request()->route('course');
//}
//return $rules;

    public function attributes()
    {
        return[
            "title"=>"عنوان",
            "slug" => "عنوان انگلیسی",
            "priority"=>"ردیف محصول",
            "price"=>"قیمت",
            "stock"=>"موجودی",
            "code_product"=>"کد محصول",
            "percent"=>"درصد فروشنده",
            "seller_id"=>"فروشنده",
            "status"=> "وضعیت",
            "category_id"=>"دسته بندی",
            "body"=>"توضیحات",
            "image" =>"تصویر محصول",
        ];
    }
}