<?php

namespace App\Http\Requests\SiteSettings;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmbeddedScriptSettingRequest extends FormRequest
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
            'head_embedded_script' => [],
            'head_embedded_script2' => [],
            'head_embedded_script3' => [],
            'body_embedded_script' => [],
            'body_embedded_script2' => [],
            'body_embedded_script3' => [],
            'body_tel_script' => [],
        ];
    }
}
