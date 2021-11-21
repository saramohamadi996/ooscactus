<?php

namespace Milano\Coupon\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class CouponRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|min:3|max:190',
            'code' => 'nullable|min:3|max:190',
            "percent"=>'nullable|numeric|min:0|max:100',
            "limit"=>'nullable|numeric',
            'quantity' => 'nullable|numeric|min:0',
            'start_at' => 'required',
            'expired_at' => 'required',
            'is_general' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان تخفیف',
            'code' => 'کد تخفیف',
            'limit' => 'مقدار تخفیف',
            'quantity' => 'تعداد کد تخفیف',
            'percent' => 'درصد تخفیف',
            'start_at' => 'تاریخ شروع',
            'expired_at' => 'تاریخ انقضا',
            'is_general' => 'وضعیت تخفیف',
        ];
    }
}
