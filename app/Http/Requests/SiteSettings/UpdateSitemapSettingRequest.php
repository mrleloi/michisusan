<?php

namespace App\Http\Requests\SiteSettings;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSitemapSettingRequest extends FormRequest
{
    protected $booleanFields = [
        'sitemap_flag'
    ];

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

    protected function prepareForValidation()
    {
        // Handle checkbox fields (set default if not provided)
        foreach ($this->booleanFields as $field) {
            $this->merge([$field => $this->has($field) ? 1 : 0]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sitemap_title' => 'nullable|max:35',
            'sitemap_description' => 'nullable|max:250',
            'sitemap_h1' => 'nullable|max:35',
            'sitemap_keywords' => 'nullable|max:35',
            'sitemap_subentry' => 'nullable|max:255',
            'sitemap_entry' => 'nullable|max:255',
            'sitemap_flag' => ['required', 'boolean'],
            'sitemap_link' => 'nullable|max:255',
            'sitemap_image' => 'nullable|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'sitemap_title.max' => 'タイトルは35文字以内で入力してください。',
            'sitemap_description.max' => 'descriptionは250文字以内で入力してください。',
            'sitemap_h1.max' => 'h1テキストは35文字以内で入力してください。',
            'sitemap_keywords.max' => 'keywordsは35文字以内で入力してください。',
            'sitemap_subentry.max' => '大見出しは255文字以内で入力してください。',
            'sitemap_entry.max' => '小見出しは255文字以内で入力してください。',
            'sitemap_flag.required' => 'サイトマップへのリンクは必須です。',
            'sitemap_flag.boolean' => 'サイトマップへのリンクは真偽値である必要があります',
            'sitemap_link.max' => 'リンクテキストは255文字以内で入力してください。',
        ];
    }
}
