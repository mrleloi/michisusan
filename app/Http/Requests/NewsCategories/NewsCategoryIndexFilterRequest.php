<?php

namespace App\Http\Requests\NewsCategories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsCategoryIndexFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'news_category_max_view' => ['nullable', Rule::in(config('views.news_categories.max_view_options'))],
            'news_category_keyword' => 'nullable',
        ];
    }
}
