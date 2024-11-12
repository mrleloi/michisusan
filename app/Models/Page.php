<?php

namespace App\Models;

use App\Behavior\SaveChangeLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    use SaveChangeLog;

    protected $fillable = [
        'site_id',
        'title',
        'with_seo_title',
        'description',
        'h1_text',
        'navigation_name',
        'directory',
        'keywords',
        'show_tag',
        'show_common_footer',
        'account',
        'password',
        'eye_catch',
        'page_id',
        'show_top_navi',
        'show_side_navi',
        'show_bottom_navi',
        'show_category',
        'show_related_page',
        'show_related_tag',
        'show_sitemap',
        'show_common_side_navi',
        'show_seo_analysis',
        'show_header',
        'show_header_logo',
        'show_header_navimenu',
        'show_header_mv',
        'show_footer',
        'show_footer_logo',
        'show_footer_navimenu',
        'show_footer_sns',
        'subnavagation_id',
        'custom_css',
        'custom_javascript',
        'custom_head_tag',
        'content',
        'publish_status',
        'published_at',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'page_id');
    }

    public function subnavigation()
    {
        return $this->hasOne(Subnavigation::class, 'id', 'subnavigation_id');
    }

    public function getTitle($site)
    {
        if (empty($site->seo_title)) {
            return $this->title;
        } else {
            $separator = $site->seo_title_separator ?? '|';
            return implode(" ${separator} ", [$site->seo_title, $this->title]);
        }
    }
}
