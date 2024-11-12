<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Site extends Model
{
    use HasFactory;
    protected $fillable = ['seo_keyword1', 'seo_keyword2', 'seo_keyword3', 'seo_title', 'seo_title_separator',
        'copyright', 'favicon_image', 'apple_touch_icon_image', 'use_www', 'breadcrumb_top', 'noindex_nofollow',
        'show_link_cookie_policy', 'account', 'password', 'robots_text', 'exclude_ips', 'industry',
        'header_layout', 'mv_overlay', 'header_scroll', 'header_width', 'title_font', 'body_font',
        'loading_animation', 'loading_animation_image', 'loading_animation_enabled', 'main_image',
        'image_display_type', 'image_popup', 'element_alignment', 'element_fadein', 'noimage_grayscale',
        'footer_layout', 'footer_width',
        'head_embedded_script',
        'head_embedded_script2',
        'head_embedded_script3',
        'body_embedded_script',
        'body_embedded_script2',
        'body_embedded_script3',
        'body_tel_script',
        'sitemap_title',
        'sitemap_description',
        'sitemap_h1',
        'sitemap_keywords',
        'sitemap_subentry',
        'sitemap_entry',
        'sitemap_flag',
        'sitemap_link',
        'sitemap_image',
        'email_address',
        'ga4_property_id',
        'ga4_tracking_code',
        'search_console_meta',
        'microsoft_clarity_tag',
        'juicer_tag',
        'ga4_json_file',
        'search_console_json_file',
        'header_content',
        'sidebar_content',
        'footer_content',
        'sidebar_content2',
    ];

    const ANALYTICS_FOLDER = 'public/settings/analytic/';
    const GA4_CONFIG_FILENAME = 'ga4-config.json';
    const GOOGLE_CONSOLE_CONFIG_FILENAME = 'google-console-config.json';

    public function categories()
    {
        return $this->hasMany(NewsCategory::class);
    }

    public function articles()
    {
        return $this->hasMany(NewsArticle::class);
    }

    public function settings()
    {
        return $this->hasOne(NewsSetting::class);
    }

    public function getGa4ConfigPath()
    {
        return self::ANALYTICS_FOLDER . '/' . $this->site_id . '/' . self::GA4_CONFIG_FILENAME;
    }

    public function getGa4ConfigFullPath()
    {
        // Return full system path when needed
        return storage_path('app/' . $this->getGa4ConfigPath());
    }

    public function getGa4ConfigContent()
    {
        if (Storage::exists($this->getGa4ConfigPath())) {
            return Storage::get($this->getGa4ConfigPath());
        }
        return null;
    }

    public function getSearchConsoleConfigPath()
    {
        return self::ANALYTICS_FOLDER . '/' . $this->site_id . '/' . self::GOOGLE_CONSOLE_CONFIG_FILENAME;
    }

    public function getSearchConsoleConfigFullPath()
    {
        // Return full system path when needed
        return storage_path('app/' . $this->getSearchConsoleConfigPath());
    }

    public function getSearchConsoleConfigContent()
    {
        if (Storage::exists($this->getSearchConsoleConfigPath())) {
            return Storage::get($this->getSearchConsoleConfigPath());
        }
        return null;
    }

    public function headerFooterSetting()
    {
        return $this->hasOne(HeaderFooterSetting::class);
    }

    public function siteSnsSetting()
    {
        return $this->hasOne(SiteSnsSetting::class);
    }

    public function sitePaymentSetting()
    {
        return $this->hasOne(SitePaymentSetting::class);
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
