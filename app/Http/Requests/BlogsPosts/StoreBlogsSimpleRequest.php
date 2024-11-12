<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Http\Requests\BlogsPosts;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreBlogsSimpleRequest extends FormRequest
{
    protected $booleanFields = [
        'show_common_footer', 'show_header', 'show_header_logo',
        'show_header_navigation_menu', 'show_header_mv', 'show_footer', 'show_footer_logo',
        'show_footer_navigation_menu', 'show_footer_sns', 'is_template'
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
        // Convert delimited strings into arrays for tags, sns IDs, and category IDs
        if (is_string($this->tags)) {
            $this->merge([
                'tags' => explode(':::', $this->tags)
            ]);
        }

        if (is_array($this->sns_id)) {
            $this->merge([
                'sns' => $this->sns_id
            ]);
        }

        if (is_array($this->category_id)) {
            $this->merge([
                'categories' => $this->category_id
            ]);
        }

        // Handle the conversion of publish status from a string to a boolean
        if (is_string($this->publish_status)) {
            $this->merge([
                'publish_status' => $this->publish_status == 'public' ? 1 : 0,
            ]);
        }

        // Handle checkbox fields (set default if not provided)
        foreach ($this->booleanFields as $field) {
            $this->merge([$field => $this->has($field) ? 1 : 0]);
        }

        // Merge additional fields that may be represented differently in the form or need adjustment
        $this->merge([
            'account' => $this->access_restriction_account,
            'password' => $this->access_restriction_password,
            'show_header_navimenu' => $this->show_header_navigation_menu,
            'show_footer_navimenu' => $this->show_footer_navigation_menu,
            'custom_javascript' => $this->custom_js,
        ]);

        // Clean up fields that should not be stored directly in the database
        $this->request->remove('access_restriction_account');
        $this->request->remove('access_restriction_password');
        $this->request->remove('show_header_navigation_menu');
        $this->request->remove('show_footer_navigation_menu');
        $this->request->remove('custom_js');
    }

    public function rules()
    {
        return [
            'title' => 'required|max:35',
            'description' => 'nullable|max:250',
            'h1_text' => 'nullable|max:35',
            'navigation_name' => 'nullable|max:35',
            'directory' => 'required|max:30',
            'content' => 'nullable',
            'keywords' => 'nullable|max:80',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255',
            'show_tag' => 'boolean',
            'show_common_footer' => 'boolean',
            'account' => 'nullable|max:30',
            'password' => 'nullable|max:30',
            'eye_catch' => 'nullable|integer|min:1',
            'simple_top_image_01' => 'nullable|integer|min:1',
            'simple_top_image_02' => 'nullable|integer|min:1',
            'simple_top_image_03' => 'nullable|integer|min:1',
            'show_header' => 'boolean',
            'show_header_logo' => 'boolean',
            'show_header_navimenu' => 'boolean',
            'show_header_mv' => 'boolean',
            'show_footer' => 'boolean',
            'show_footer_logo' => 'boolean',
            'show_footer_navimenu' => 'boolean',
            'show_footer_sns' => 'boolean',
            'subnavigation_id' => 'nullable',
//            'subnavigation_id' => 'nullable|exists:blogs_subnavigations,id',
            'custom_css' => 'nullable',
            'custom_javascript' => 'nullable',
            'custom_head_tag' => 'nullable',
            'is_template' => 'boolean',
            'published_at' => 'nullable|date',
            'publish_status' => 'nullable',
            'sns' => 'nullable|array',
            'sns.*' => 'exists:blogs_sns,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:blogs_categories,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須です。',
            'title.max' => 'タイトルは35文字以内で入力してください。',
            'description.max' => '説明は250文字以内で入力してください。',
            'h1_text.max' => 'H1テキストは20文字以内で入力してください。',
            'navigation_name.max' => 'ナビゲーション表示名は35文字以内で入力してください。',
            'directory.required' => 'ディレクトリ名は必須です。',
            'directory.max' => 'ディレクトリ名は30文字以内で入力してください。',
            'tags.array' => 'タグは配列形式である必要があります。',
            'tags.*.max' => '各タグは255文字以内で入力してください。',
            'account.max' => 'アカウントは30文字以内で入力してください。',
            'password.max' => 'パスワードは30文字以内で入力してください。',
            'show_tag.boolean' => '関連タグ表示は真偽値である必要があります。',
            'show_common_footer.boolean' => '共通フッター表示は真偽値である必要があります。',
            'show_header.boolean' => 'ヘッダー表示は真偽値である必要があります。',
            'show_header_logo.boolean' => 'ヘッダーロゴ表示は真偽値である必要があります。',
            'show_header_navimenu.boolean' => 'ヘッダーナビメニュー表示は真偽値である必要があります。',
            'show_header_mv.boolean' => 'ヘッダーMV表示は真偽値である必要があります。',
            'show_footer.boolean' => 'フッター表示は真偽値である必要があります。',
            'show_footer_logo.boolean' => 'フッターロゴ表示は真偽値である必要があります。',
            'show_footer_navimenu.boolean' => 'フッターナビメニュー表示は真偽値である必要があります。',
            'show_footer_sns.boolean' => 'フッターSNS表示は真偽値である必要があります。',
            'keywords.max' => 'キーワードは80文字以内で入力してください。',
            'eye_catch.image' => 'アイキャッチ画像は画像ファイルである必要があります。',
            'eye_catch.max' => 'アイキャッチ画像は5MB以下である必要があります。',
            'subnavigation_id.exists' => '選択されたサブナビゲーションは存在しません。',
            'is_template.boolean' => 'テンプレートフラグは真偽値である必要があります。',
            'published_at.date' => '公開日時は有効な日付である必要があります。',
            'sns.*.exists' => '選択されたSNSは存在しません。',
            'categories.*.exists' => '選択されたカテゴリーは存在しません。',
        ];
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
