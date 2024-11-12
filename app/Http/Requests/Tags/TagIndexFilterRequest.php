<?php

namespace App\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagIndexFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tag_max_view' => ['nullable', Rule::in(config('views.tags.max_view_options'))],
            'tag_keyword' => 'nullable',
        ];
    }
}
