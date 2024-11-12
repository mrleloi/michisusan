<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecruitingSettingRequest extends FormRequest
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
            'page_title' => 'max:35',
            'description' => 'max:250',
            'h1_text' => 'max:35',
            'navi_display_name' => 'max:100',
            'directory_name' => 'required|max:250|regex:/^[0-9a-zA-Z]+$/',
            'keywords' => 'max:250|regex:/^[0-9a-zA-Z,]+$/|nullable',
            'navi_menu' => '',
            'add_to_site_map' => 'boolean',
            'show_sns_on_footer' => 'boolean',
            'common_footer' => '',
            'header_image_id' => ['exists:image_files,id'],
            'header_image_id_delete' => ['boolean'],
            'show_header_image' => 'boolean',
            'design' => 'integer',
            'number_of_items' => '',
            'number_of_articles' => 'boolean',
            'category_navi_type' => 'integer',
            'article_order' => 'integer',
            'original_head_tag' => '',
            'above_title' => 'max:250',
            'above_subtitle' => 'max:250',
            'above_text' => '',
            'above_titles_position' => 'integer',
            'above_text_position' => 'integer',
            'below_title' => 'max:250',
            'below_subtitle' => 'max:250',
            'below_text' => '',
            'below_titles_position' => 'integer',
            'below_text_position' => 'integer',
        ];
    }

    public function attributes(): array
    {
        return [
            'page_title' => 'ページタイトル',
            'description' => 'description',
            'h1_text' => 'ｈ１テキスト',
            'navi_display_name' => 'ナビ表示名',
            'directory_name' => 'ディレクトリ名',
            'keywords' => 'keywords',
            'navi_menu' => 'ナビメニュー',
            'add_to_site_map' => 'サイトマップに追加',
            'show_sns_on_footer' => 'SNSボタンを表示する',
            'common_footer' => '共通フッター',
            'header_image_id' => '見出し画像',
            'show_header_image' => '見出し画像の表示',
            'design' => 'デザイン',
            'number_of_items' => '表示件数',
            'number_of_articles' => '記事数',
            'category_navi_type' => 'カテゴリナビ',
            'article_order' => '並び順',
            'original_head_tag' => '独自<head>タグ内容',
            'above_title' => '上部タイトル',
            'above_subtitle' => '上部サブタイトル',
            'above_text' => '上部テキスト',
            'above_titles_position' => '上部タイトル・サブタイトルの表示位置',
            'above_text_position' => '上部テキストの表示位置',
            'below_title' => '下部タイトル',
            'below_subtitle' => '下部サブタイトル',
            'below_text' => '下部テキスト',
            'below_titles_position' => '下部タイトル・サブタイトルの表示位置',
            'below_text_position' => '下部テキストの表示位置',
        ];
    }

    public function messages()
    {
        return [
            'directory_name' => [
                'regex' => ':attributeは半角英数字のみ入力できます。'
            ],
            'keywords' => [
                'regex' => ':attributeは半角英数字カンマのみ入力できます。'
            ],
        ];
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->setValueNames([
        ]);

        return $validator;
    }
}
