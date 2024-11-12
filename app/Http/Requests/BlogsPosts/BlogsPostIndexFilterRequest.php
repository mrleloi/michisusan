<?php

namespace App\Http\Requests\BlogsPosts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogsPostIndexFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'blogs_post_category_id' => 'nullable|exists:blogs_categories,id',
            'blogs_post_max_view' => ['nullable', Rule::in(config('views.blogs_posts.max_view_options'))]
        ];
    }
}
