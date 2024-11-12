<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsSetting extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id', 'name', 'with_seo_title', 'directory', 'page_title',
        'description', 'h1_text', 'keywords', 'show_in_header_navimenu', 'show_in_footer_navimenu',
        'show_in_site_map', 'show_sns', 'show_footer_index', 'show_footer_articles',
        'heading_image', 'show_heading_image', 'design_type', 'per_page', 'show_total_number',
        'show_archive', 'show_published_at', 'show_updated_at',
        'top_signature', 'bottom_signature', 'subnavigation_id', 'account', 'password',
        'custom_head_tag', 'top_title', 'top_subtitle', 'top_text', 'top_title_position',
        'top_text_position', 'bottom_title', 'bottom_subtitle', 'bottom_text',
        'bottom_title_position', 'bottom_text_position', 'introduction_title',
        'introduction_image', 'introduction'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function subnavigation()
    {
        return $this->belongsTo(NewsSubnavigation::class, 'subnavigation_id');
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
