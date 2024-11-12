<?php

namespace App\Http\Requests\SitePaymentSetting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateSitePaymentSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'show_payment_button' => ['required', 'boolean'],
            'show_paypal' => ['boolean'],
            'show_aupay' => ['boolean'],
            'show_dpay' => ['boolean'],
            'show_merpay' => ['boolean'],
            'show_rakutenpay' => ['boolean'],
            'show_visa' => ['boolean'],
            'show_master' => ['boolean'],
            'show_jcb' => ['boolean'],
            'show_amex' => ['boolean'],
            'show_diners' => ['boolean'],
            'show_discover' => ['boolean'],
            'show_unionpay' => ['boolean'],
            'show_electronicmoney' => ['boolean'],
            'description' => ['nullable', 'string'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return back()->withInput()->withErrors($validator);
    }
}
