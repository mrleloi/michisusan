<?php
namespace App\Http\Requests\Tags;

use App\Http\Requests\FormRequest;
use App\Models\NewsCategory;
use App\Models\Tag;
use App\Rules\MaxFullHalfWidth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreTagRequest extends FormRequest
{
    protected $booleanFields = [
    ];

    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        return back()->withInput()->withErrors($validator);
    }

    protected function prepareForValidation()
    {
        // Handle default if not provided
        if (!($this->has('show_description'))) {
            $this->merge([
                'show_description' => 1,
            ]);
        }

        if (!($this->has('publish_status'))) {
            $this->merge([
                'publish_status' => 1,
            ]);
        }
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', new MaxFullHalfWidth(30)],
            'description_top' => ['nullable', 'string', new MaxFullHalfWidth(1000)],
            'description_bottom' => ['nullable', 'string', new MaxFullHalfWidth(1000)],
            'show_description' => 'boolean',
            'h1_text' => ['nullable', 'string', new MaxFullHalfWidth(80)],
            'publish_status' => [
                'nullable',
                Rule::in([Tag::STATUS_UNPUBLISHED, Tag::STATUS_PUBLISHED]),
            ],
            'order' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'タグ名を入力してください',
            'name.App\Rules\MaxFullHalfWidth' => '見出しは30文字以内で入力してください。',
            'description_top.App\Rules\MaxFullHalfWidth' => '上部詳細は1000文字以内で入力してください。',
            'description_bottom.App\Rules\MaxFullHalfWidth' => '上部詳細は1000文字以内で入力してください。',
            'show_description.boolean' => '説明表示は真偽値である必要があります。',
            'h1_text.App\Rules\MaxFullHalfWidth' => 'h1テキストは80文字以内で入力してください。',
            'publish_status.in' => '公開ステータスは有効な値である必要があります。',
            'order.integer' => '順序は整数である必要があります。',
        ];
    }
}
