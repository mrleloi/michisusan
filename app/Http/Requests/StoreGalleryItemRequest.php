<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryItemRequest extends FormRequest
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
            'gallery_category_id' => 'required|integer',
            'title' => 'required|max:50',
            'subtitle' => 'required|max:80',
            'summary' => 'required|max:500',
            'description' => 'required|max:1000',
            'image_id' => ['exists:image_files,id'],
            'image_id_delete' => ['boolean'],
            //'link_url',
            /*
            'show_button1' => 'required|integer',
            'button1_link_type' => 'required|integer',
            'button1_link_page_id' => 'required_if:button1_link_type,1|integer',
            'button1_link_url' => 'required_if:button1_link_type,2',
            'button1_text' => 'required|max:100',
            'button1_link_open_type' => 'required|integer',
            'show_button2' => 'required|integer',
            'button2_link_type' => 'required|integer',
            'button2_link_page_id' => 'required_if:button2_link_type,1|integer',
            'button2_link_url' => 'required_if:button2_link_type,2',
            'button2_text' => 'required|max:100',
            'button2_link_open_type' => 'required|integer',
            'show_button3' => 'required|integer',
            'button3_link_type' => 'required|integer',
            'button3_link_page_id' => 'required_if:button3_link_type,1|integer',
            'button3_link_url' => 'required_if:button3_link_type,2',
            'button3_text' => 'required|max:100',
            'button3_link_open_type' => 'required|integer',
            */
            'visible' => 'required|integer',
            //'sort_order',

            'rows.*' => 'required|array',
            'rows.*.id' => '',
            'rows.*.sort_order' => '',
            'rows.*.image_id' => ['exists:image_files,id'],
            'rows.*.image_id_delete' => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'gallery_category_id' => 'ギャラリーカテゴリ',
            'title' => 'タイトル',
            'subtitle' => 'サブタイトル',
            'summary' => '説明（抜粋）',
            'description' => '説明（詳細）',
            'image_id' => 'アイキャッチ画像',
            'link_url' => '外部リンク',
            'show_button1' => 'ボタン（１）-表示',
            'button1_link_type' => 'ボタン（１）- リンクタイプ',
            'button1_link_page_id' => 'ボタン（１）- サイト内リンク',
            'button1_link_url' => 'ボタン（１）- 外部リンク',
            'button1_text' => 'ボタン（１）- ボタンに表示する文言',
            'button1_link_open_type' => 'ボタン（１）- ウィンドウの開き方',
            'show_button2' => 'ボタン（２）-表示',
            'button2_link_type' => 'ボタン（２）- リンクタイプ',
            'button2_link_page_id' => 'ボタン（２）- サイト内リンク',
            'button2_link_url' => 'ボタン（２）- 外部リンク',
            'button2_text' => 'ボタン（２）- ボタンに表示する文言',
            'button2_link_open_type' => 'ボタン（２）- ウィンドウの開き方',
            'show_button3' => 'ボタン（３）-表示',
            'button3_link_type' => 'ボタン（３）- リンクタイプ',
            'button3_link_page_id' => 'ボタン（３）- サイト内リンク',
            'button3_link_url' => 'ボタン（３）- 外部リンク',
            'button3_text' => 'ボタン（３）- ボタンに表示する文言',
            'button3_link_open_type' => 'ボタン（３）- ウィンドウの開き方',
            'visible' => '表示・非表示',

            'rows.*.id' => '画像[ID]',
            'rows.*.sort_order' => '画像[並び順]',
            'rows.*.image_id' => '画像[イメージID]',
            //'sia_contents.*' => '',
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->setValueNames([
            'button1_link_type' => [
                '1' => 'リンクタイプ（サイト内）',
                '2' => 'リンクタイプ（外部リンク）',
            ],
            'button2_link_type' => [
                '1' => 'リンクタイプ（サイト内）',
                '2' => 'リンクタイプ（外部リンク）',
            ],
            'button3_link_type' => [
                '1' => 'リンクタイプ（サイト内）',
                '2' => 'リンクタイプ（外部リンク）',
            ],
        ]);

        return $validator;
    }
}
