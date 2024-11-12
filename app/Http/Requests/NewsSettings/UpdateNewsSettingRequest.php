<?php
namespace App\Http\Requests\NewsSettings;

use App\Http\Requests\FormRequest;
use App\Rules\MaxFullHalfWidth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateNewsSettingRequest extends FormRequest
{
    protected $booleanFields = [
        'with_seo_title', 'show_in_header_navimenu', 'show_in_footer_navimenu', 'show_in_site_map',
        'show_sns', 'show_footer_index', 'show_footer_articles', 'show_archive', 'show_published_at',
        'show_updated_at'
    ];

    /*protected $setDefaultTrueFields = [
        'show_heading_image', 'show_total_number', 'top_title_position', 'top_text_position',
        'bottom_title_position', 'bottom_text_position'
    ];*/

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Implement your authorization logic here
        // For example, check if the user owns the news article or has the right permissions
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        return back()->withInput()->withErrors($validator);
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Handle default if not provided
        /*foreach ($this->setDefaultTrueFields as $field) {
            if (!($this->has($field))) {
                $this->merge([$field => 1]);
            }
        }*/
        if (!($this->has('per_page'))) {
            $this->merge(['per_page' => 10]);
        }

        // Handle checkbox fields (set default if not provided)
        foreach ($this->booleanFields as $field) {
            $this->merge([$field => $this->has($field) ? 1 : 0]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', new MaxFullHalfWidth(255)],
            'with_seo_title' => 'boolean',
            'directory' => ['required', 'string', new MaxFullHalfWidth(30)],
            'page_title' => ['nullable', 'string', new MaxFullHalfWidth(50)],
            'description' => ['nullable', 'string', new MaxFullHalfWidth(120)],
            'h1_text' => ['nullable', 'string', new MaxFullHalfWidth(50)],
            'keywords' => ['nullable', 'string', new MaxFullHalfWidth(120)],
            'show_in_header_navimenu' => 'boolean',
            'show_in_footer_navimenu' => 'boolean',
            'show_in_site_map' => 'boolean',
            'show_sns' => 'boolean',
            'show_footer_index' => 'boolean',
            'show_footer_articles' => 'boolean',
            'heading_image' => 'nullable|integer|min:1',
            'show_heading_image' => 'boolean',
            'design_type' => 'nullable|integer',
            'per_page' => 'required|integer',
            'show_total_number' => 'boolean',
            'show_archive' => 'boolean',
            'show_published_at' => 'boolean',
            'show_updated_at' => 'boolean',
            'top_signature' => 'nullable|string',
            'bottom_signature' => 'nullable|string',
            'subnavigation_id' => 'nullable',
//            'subnavigation_id' => 'nullable|exists:news_subnavigations,id',
            'account' => 'nullable|string|max:30',
            'password' => 'nullable|string|max:30',
            'custom_head_tag' => 'nullable|string',
            'top_title' => ['nullable', 'string', new MaxFullHalfWidth(50)],
            'top_subtitle' => ['nullable', 'string', new MaxFullHalfWidth(50)],
            'top_text' => ['nullable', 'string', new MaxFullHalfWidth(50)],
            'top_title_position' => 'nullable|integer',
            'top_text_position' => 'nullable|integer',
            'bottom_title' => ['nullable', 'string', new MaxFullHalfWidth(50)],
            'bottom_subtitle' => ['nullable', 'string', new MaxFullHalfWidth(50)],
            'bottom_text' => ['nullable', 'string', new MaxFullHalfWidth(50)],
            'bottom_title_position' => 'nullable|integer',
            'bottom_text_position' => 'nullable|integer',
            'introduction_title' => 'nullable|string|max:50',
            'introduction_image' => 'nullable|string|max:255',
            'introduction' => ['nullable', 'string', new MaxFullHalfWidth(1000)],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前は必須です。',
            'name.string' => '名前は文字列である必要があります。',
            'name.App\Rules\MaxFullHalfWidth' => '名前は255文字以内で入力してください。',
            'with_seo_title.boolean' => 'SEOタイトル追加は真偽値である必要があります。',
            'directory.required' => 'ディレクトリ名は必須です。',
            'directory.string' => 'ディレクトリ名は文字列である必要があります。',
            'directory.App\Rules\MaxFullHalfWidth' => 'ディレクトリ名は30文字以内で入力してください。',
            'page_title.App\Rules\MaxFullHalfWidth' => 'ページタイトルは50文字以内で入力してください。',
            'description.App\Rules\MaxFullHalfWidth' => '説明は120文字以内で入力してください。',
            'h1_text.App\Rules\MaxFullHalfWidth' => 'H1テキストは50文字以内で入力してください。',
            'keywords.App\Rules\MaxFullHalfWidth' => 'キーワードは120文字以内で入力してください。',
            'show_in_header_navimenu.boolean' => 'ヘッダーナビメニュー表示は真偽値である必要があります。',
            'show_in_footer_navimenu.boolean' => 'フッターナビメニュー表示は真偽値である必要があります。',
            'show_in_site_map.boolean' => 'サイトマップ表示は真偽値である必要があります。',
            'show_sns.boolean' => 'SNS表示は真偽値である必要があります。',
            'show_footer_index.boolean' => 'インデックスフッター表示は真偽値である必要があります。',
            'show_footer_articles.boolean' => '記事フッター表示は真偽値である必要があります。',
            'heading_image.max' => '見出し画像は255文字以内で入力してください。',
            'show_heading_image.boolean' => '見出し画像表示は真偽値である必要があります。',
            'design_type.integer' => 'デザインタイプは整数である必要があります。',
            'per_page.required' => '1ページあたりの表示件数は必須です。',
            'per_page.integer' => '1ページあたりの表示件数は整数である必要があります。',
            'show_total_number.boolean' => '総数表示は真偽値である必要があります。',
            'show_archive.boolean' => 'アーカイブ表示は真偽値である必要があります。',
            'show_published_at.boolean' => '公開日時表示は真偽値である必要があります。',
            'show_updated_at.boolean' => '更新日時表示は真偽値である必要があります。',
            'subnavigation_id.exists' => '選択されたサブナビゲーションは存在しません。',
            'account.max' => 'アカウントは30文字以内で入力してください。',
            'password.max' => 'パスワードは30文字以内で入力してください。',
            'top_title.App\Rules\MaxFullHalfWidth' => '上部タイトルは50文字以内で入力してください。',
            'top_subtitle.App\Rules\MaxFullHalfWidth' => '上部サブタイトルは50文字以内で入力してください。',
            'top_text.App\Rules\MaxFullHalfWidth' => '上部テキストは50文字以内で入力してください。',
            'top_title_position.integer' => '上部タイトル位置は整数である必要があります。',
            'top_text_position.integer' => '上部テキスト位置は整数である必要があります。',
            'bottom_title.App\Rules\MaxFullHalfWidth' => '下部タイトルは50文字以内で入力してください。',
            'bottom_subtitle.App\Rules\MaxFullHalfWidth' => '下部サブタイトルは50文字以内で入力してください。',
            'bottom_text.App\Rules\MaxFullHalfWidth' => '下部テキストは50文字以内で入力してください。',
            'bottom_title_position.integer' => '下部タイトル位置は整数である必要があります。',
            'bottom_text_position.integer' => '下部テキスト位置は整数である必要があります。',
            'introduction_title.max' => '紹介タイトルは50文字以内で入力してください。',
            'introduction_image.App\Rules\MaxFullHalfWidth' => '紹介画像は1000文字以内で入力してください。',
        ];
    }
}
