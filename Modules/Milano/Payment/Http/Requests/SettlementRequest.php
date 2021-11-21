<?php
namespace Milano\Payment\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Milano\Payment\Models\Settlement;

class SettlementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        if (request()->getMethod() === "PATCH") {
            return [
                "from.name" => "required_if:status," . Settlement::STATUS_SETTLED,
                "from.cart" => "required_if:status," . Settlement::STATUS_SETTLED,
                "to.name" => "required_if:status," . Settlement::STATUS_SETTLED,
                "to.cart" => "required_if:status," . Settlement::STATUS_SETTLED,
                "amount" => "required|numeric",
            ];
        }
        return [
            "name" => "required",
            "cart" => "required|numeric",
            "amount" => "required|numeric|max:" . auth()->user()->balance
        ];
    }

    public function attributes()
    {
        return [
            "cart" => "شماره کارت",
            "amount" => "مبلغ تسویه حساب"
        ];
    }
}
