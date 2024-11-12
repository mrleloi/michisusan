<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGallerySettingRequest extends FormRequest
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
            //
            'page_title' => 'max:35',
            'description' => 'max:250',
            'h1_text' => 'max:35',
            'navi_display_name' => 'max:100',
            'directory_name' => 'required|max:250|regex:/^[0-9a-zA-Z]+$/',
            'keywords' => 'max:250|regex:/^[0-9a-zA-Z,]+$/|nullable',
            'navi_menu' => 'max:20',
            'footer' => 'max:20',
            'header_image_id' => ['exists:image_files,id'],
            'header_image_id_delete' => ['boolean'],
            'show_header_image' => 'boolean',
            'list_design' => 'integer',
            'detail_design' => 'integer',
            'show_detail_page' => 'integer',
            'show_inquiry_button' => 'boolean',
            'number_of_items' => '',
            'number_of_articles' => 'boolean',
            'category_navi_type' => 'integer',
            'show_all_name' => 'max:250',
            'article_order' => 'integer',
            'subnavigation' => 'integer',
            'access_limitation_account' => 'max:30',
            'access_limitation_password' => 'max:16',
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
            'footer' => 'フッター',
            'header_image_id' => '見出し画像',
            'show_header_image' => '見出し画像の表示',
            'list_design' => '一覧デザイン',
            'detail_design' => '詳細デザイン',
            'show_detail_page' => '詳細ページ',
            'show_inquiry_button' => '詳細ページに問い合わせボタン',
            'number_of_items' => '表示件数',
            'number_of_articles' => '記事数',
            'category_navi_type' => 'カテゴリナビ',
            'show_all_name' => '全件表示時の名称',
            'article_order' => '記事の並び順',
            'subnavigation' => 'サブナビゲーション',
            'access_limitation_account' => 'アクセス制限（アカウント）',
            'access_limitation_password' => 'アクセス制限（パスワード）',
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
