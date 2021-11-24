<?php
namespace Milano\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Milano\Product\Models\Product;
use Illuminate\Validation\Rule;
use Milano\Product\Rules\ValidSeller;

class ProductAllRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return  $rules = [
            "title"=>'nullable|unique:products,title|min:3|max:190',
            "code_product"=>'nullable|unique:products,code_product',
            "priority"=>'nullable|unique:products,priority||numeric|min:0',
            "price"=>'nullable|numeric|min:0|max:1000000000',
            "seller_id"=>['nullable','exists:users,id', new ValidSeller()],
            "category_id"=>'nullable|exists:categories,id',
        ];
    }

    public function attributes()
    {
        return[
            "title"=>"عنوان",
            "priority"=>"ردیف محصول",
            "price"=>"قیمت",
            "code_product"=>"کد محصول",
            "seller_id"=>"فروشنده",
            "category_id"=>"دسته بندی",
        ];
    }
}
