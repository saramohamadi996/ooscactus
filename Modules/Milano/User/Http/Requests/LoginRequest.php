<?php

namespace Milano\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Milano\User\Service\CheckAndConvertNumber;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'min:11', 'max:13', 'regex:/^(\+98|0098|98|0)?9\d{9}$/i'],
        ];
    }

    /**
     * Automatic conversion of Persian and Arabic numbers to English
     */
    protected function prepareForValidation()
    {
        $this->merge([
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
