<?php
namespace App\Http\Requests\NewsCategories;

use App\Http\Requests\FormRequest;
use App\Models\NewsCategory;
use App\Rules\MaxFullHalfWidth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreNewsCategoryRequest extends FormRequest
{
    protected $booleanFields = [
//        'show_description', 'publish_status',
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
            'name' => ['required', 'string', new MaxFullHalfWidth(30), 'unique:news_categories,name'],
            'description_heading' => ['nullable', 'string', new MaxFullHalfWidth(80)],
            'description_top' => ['nullable', 'string', new MaxFullHalfWidth(1000)],
            'description_bottom' => ['nullable', 'string', new MaxFullHalfWidth(1000)],
            'show_description' => 'boolean',
            'h1_text' => ['nullable', 'string', new MaxFullHalfWidth(80)],
            'seleted_text' => ['nullable', 'string', new MaxFullHalfWidth(80)],
            'link_type' => [
                'nullable',
                Rule::in([
                    NewsCategory::LINK_TYPE_NO_DISPLAY,
                    NewsCategory::LINK_TYPE_INTERNAL,
                    NewsCategory::LINK_TYPE_EXTERNAL
                ]),
            ],
            'link_page_id' => [
                'nullable',
//                Rule::exists('pages', 'id'),
            ],
            'link_url' => [
                'nullable',
                'string',
                'max:500',
            ],
            'link_open_type' => [
                'nullable',
                Rule::in([NewsCategory::LINK_OPEN_SAME_WINDOW, NewsCategory::LINK_OPEN_NEW_WINDOW]),
            ],
            'publish_status' => [
                'nullable',
                Rule::in([NewsCategory::STATUS_UNPUBLISHED, NewsCategory::STATUS_PUBLISHED]),
            ],
            'order' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'カテゴリー名を入力してください',
            'name.App\Rules\MaxFullHalfWidth' => '見出しは30文字以内で入力してください。',
            'description_heading.App\Rules\MaxFullHalfWidth' => '見出しは80文字以内で入力してください。',
            'description_top.App\Rules\MaxFullHalfWidth' => '上部詳細は1000文字以内で入力してください。',
            'description_bottom.App\Rules\MaxFullHalfWidth' => '上部詳細は1000文字以内で入力してください。',
            'show_description.boolean' => '説明表示は真偽値である必要があります。',
            'h1_text.App\Rules\MaxFullHalfWidth' => 'h1テキストは80文字以内で入力してください。',
            'seleted_text.App\Rules\MaxFullHalfWidth' => 'カテゴリ選択時テキストは80文字以内で入力してください。',
            'link_type.in' => '選択されたリンクタイプが無効です。',
            'link_page_id.exists' => '選択されたページは存在しません。',
            'link_url.max' => 'URLは500文字以内で入力してください。',
            'link_open_type.in' => '選択されたリンクの開き方が無効です。',
            'publish_status.in' => '公開ステータスは有効な値である必要があります。',
            'order.integer' => '順序は整数である必要があります。',
        ];
    }
}
