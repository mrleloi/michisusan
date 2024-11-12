<?php

namespace App\Http\Requests\SiteSettings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralSettingRequest extends FormRequest
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
            'seo_keyword1' => [],
            'seo_keyword2' => [],
            'seo_keyword3' => [],
            'seo_title' => [],
            'seo_title_separator' => [],
            'copyright' => [],
            'favicon_image' => [],
            'clear_favicon_image' => ['boolean'],
            'apple_touch_icon_image' => [],
            'clear_apple_touch_icon_image' => ['boolean'],
            'use_www' => ['int'],
            'breadcrumb_top' => [],
            'noindex_nofollow' => ['boolean'],
            'show_link_cookie_policy' => ['int'],
            'account' => [],
            'password' => [],
            'robots_text' => [],
            'exclude_ips' => [],
        ];
    }

    public function attributes()
    {
        return [
            'seo_keyword1' => 'SEOキーワード1',
            'seo_keyword2' => 'SEOキーワード2',
            'seo_keyword3' => 'SEOキーワード3',
            'seo_title' => 'SEO付与タイトル',
            'seo_title_separator' => 'SEO付与タイトル区切り',
            'copyright' => 'コピーライトに表記する文字',
            'favicon_image' => 'favicon',
            'apple_touch_icon_image' => 'appleｰtouchｰicon',
            'use_www' => 'wwwの有り無し',
            'breadcrumb_top' => 'TOPパンくず表示',
            'noindex_nofollow' => 'noindex / nofollow',
            'show_link_cookie_policy' => 'クッキーポリシーへのリンク配置設定',
            'account' => 'アクセス制限 - アカウント',
            'password' => 'アクセス制限 - パスワード',
            'robots_text' => 'robots.txt',
            'exclude_ips' => '電話番号ボタン除外IP',
        ];
    }    
}
