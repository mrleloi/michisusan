<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecruitingCategoryRequest extends FormRequest
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
            'name' => ['max:250', 'required'],
            'alias' => ['max:250'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => '求人情報ーカテゴリー名',
            'alias' => '求人情報カテゴリー別名',
        ];
    }
}