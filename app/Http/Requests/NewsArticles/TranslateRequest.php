<?php

namespace App\Http\Requests\NewsArticles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TranslateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'translate_word' => 'required|string|max:255'
        ];
    }
}
