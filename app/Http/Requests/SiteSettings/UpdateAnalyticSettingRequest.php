<?php

namespace App\Http\Requests\SiteSettings;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAnalyticSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        return back()->withInput()->withErrors($validator);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email_address' => 'nullable|email|max:255',
            'ga4_property_id' => 'nullable|string|max:255',
            'ga4_tracking_code' => 'nullable|string',
            'search_console_meta' => 'nullable|string|max:255',
            'microsoft_clarity_tag' => 'nullable|string',
            'juicer_tag' => 'nullable|string',
            'ga4_json_file' => 'nullable|file|mimes:json',
            'search_console_json_file' => 'nullable|file|mimes:json',
        ];
    }

    public function messages()
    {
        return [
            'email_address.email' => '有効なメールアドレスを入力してください。',
            'email_address.max' => 'メールアドレスは255文字以内で入力してください。',
            'ga4_property_id.max' => 'GA4のプロパティIDは255文字以内で入力してください。',
            'search_console_meta.max' => 'Search Consoleの認証メタは255文字以内で入力してください。',
            'ga4_json_file.mimes' => 'GA4 JSONファイルは有効なJSONファイルである必要があります。',
            'search_console_json_file.mimes' => 'Search Console JSONファイルは有効なJSONファイルである必要があります。',
        ];
    }
}
