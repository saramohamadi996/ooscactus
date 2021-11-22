<?php

namespace Milano\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Milano\User\Service\CheckAndConvertNumber;

class VerifyCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            "verify_code" => ['required', 'size:5'],
            "mobile" => ['required', 'min:11', 'max:13', 'regex:/^(\+98|0098|98|0)?9\d{9}$/i'],
        ];
    }

    /**
     * Automatic conversion of Persian and Arabic numbers to English
     */
    public function prepareForValidation()
    {
        $this->merge([
            'verify_code' => CheckAndConvertNumber::ConvertPerNumToEn($this->input('verify_code')),
            'mobile' => CheckAndConvertNumber::ConvertPerNumToEn($this->input('mobile')),
        ]);
    }


    /**
     * Translate request verification attributes.
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            "verify_code" => "کد تایید",
            "mobile" => "موبایل",
        ];
    }

    /**
     * Request text translation error message.
     * @return string
     */
    public function errorMessage(): string
    {
        return 'داده های داده شده نامعتبر بود.';
    }
}
