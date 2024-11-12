<?php

namespace App\Http\Requests\BlogsCategories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogsCategoryIndexFilterRequest extends FormRequest
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
            'blogs_category_max_view' => ['nullable', Rule::in(config('views.blogs_categories.max_view_options'))],
            'blogs_category_keyword' => 'nullable',
        ];
    }
}
