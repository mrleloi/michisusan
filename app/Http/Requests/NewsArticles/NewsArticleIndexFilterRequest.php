<?php

namespace App\Http\Requests\NewsArticles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsArticleIndexFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'news_article_category_id' => 'nullable|exists:news_categories,id',
            'news_article_max_view' => ['nullable', Rule::in(config('views.news_articles.max_view_options'))]
        ];
    }
}
