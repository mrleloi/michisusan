<?php

namespace App\Http\Requests\SiteSettings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppearanceSettingRequest extends FormRequest
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
            'header_layout' => ['nullable', 'int'],
            'mv_overlay' => ['nullable', 'boolean'],
            'header_scroll' => ['nullable', 'boolean'],
            'header_width' => ['nullable', 'int'],
            'title_font' => ['int'],
            'body_font' => ['int'],
            'loading_animation' => ['int'],
            'loading_animation_image' => [],
            'loading_animation_enabled' => ['boolean'],
            'main_image' => [],
            'image_display_type' => ['int'],
            'image_popup' => ['boolean'],
            'element_alignment' => ['int'],
            'element_fadein' => ['int'],
            'noimage_grayscale' => ['boolean'],
            'footer_layout' => ['int'],
            'footer_width' => ['int'],
        ];
    }

    public function attributes()
    {
        return [
            'header_layout' => 'ヘッダレイアウト',
            'mv_overlay' => 'headerがMVに重なるか',
            'header_scroll' => 'headerスクロール追従',
            'header_width' => 'header幅',
            'title_font' => 'タイトルフォント',
            'body_font' => '本文フォント',
            'loading_animation' => 'ローディングパターン',
            'loading_animation_image' => 'ローディング画像',
            'loading_animation_enabled' => 'ローディングの表示',
            'main_image' => '共通メイン画像',
            'image_display_type' => '画像の表示方法',
            'image_popup' => '画像のポップアップ',
            'element_alignment' => 'デフォルトの表示位置',
            'element_fadein' => 'デフォルトの時差表示',
            'noimage_grayscale' => 'ノーイメージ画像のグレースケール',
            'footer_layout' => 'footerレイアウトパターン',
            'footer_width' => 'footer幅',
        ];
    }    
}
