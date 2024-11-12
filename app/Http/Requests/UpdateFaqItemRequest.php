<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqItemRequest extends FormRequest
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
            'faq_category_id' => ['int', 'exists:faq_categories,id'],
            'question' => ['required'],
            'answer' => ['required'],
            'visible' => ['boolean'],
        ];
    }

    public function attributes()
    {
        return [
            'faq_category_id' => 'カテゴリー',
            'question' => '質問', 
            'answer' => '回答', 
        ];
    }
}
