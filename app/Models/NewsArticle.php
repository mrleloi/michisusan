<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Models;

use App\Behavior\SaveChangeLog;
use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    use HasFactory;
    use SiteMust;
    use SaveChangeLog;

    protected $fillable = [
        'site_id', 'title', 'description', 'content', 'keywords', 'eye_catch',
        'publish_status', 'published_at',
        'show_tag', 'show_common_footer', 'account', 'password', 'show_header',
        'show_header_logo', 'show_header_navimenu', 'show_header_mv', 'show_footer',
        'show_footer_logo', 'show_footer_navimenu', 'show_footer_sns',
        'custom_css', 'custom_javascript', 'custom_head_tag', 'navigation_name', 'directory', 'subnavigation_id', 'h1_text'
    ];

    protected $casts = [
        'show_tag' => 'boolean',
        'show_common_footer' => 'boolean',
        'show_header' => 'boolean',
        'show_header_logo' => 'boolean',
        'show_header_navimenu' => 'boolean',
        'show_header_mv' => 'boolean',
        'show_footer' => 'boolean',
        'show_footer_logo' => 'boolean',
        'show_footer_navimenu' => 'boolean',
        'show_footer_sns' => 'boolean',
        'is_template' => 'boolean',
    ];

    protected $appends = ['is_template'];

    const STATUS_UNPUBLISHED = 0;
    const STATUS_PUBLISHED = 1;

    public static $publishStatusText = [
        self::STATUS_UNPUBLISHED => '非公開',
        self::STATUS_PUBLISHED => '公開',
    ];

    public function getPublishStatusTextAttribute()
    {
        return self::$publishStatusText[$this->publish_status] ?? '不明';
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function tags()
    {
        return $this->hasMany(NewsTag::class);
    }


    public function sns()
    {
        return $this->belongsToMany(NewsSns::class, 'news_article_sns');
    }

    public function categories()
    {
        return $this->belongsToMany(NewsCategory::class, 'news_article_category');
    }

    public function template()
    {
        return $this->hasOne(NewsTemplate::class, 'article_id');
    }

    public function getIsTemplateAttribute()
    {
        return $this->template()->exists();
    }

    public function subnavigation()
    {//        return $this->belongsTo(NewsSubnavigation::class, 'subnavigation_id');
        if ($this->subnavigation_id) {
            return $this->getFakeSubnavigation($this->subnavigation_id);
        }
        return null;
    }

    protected function getFakeSubnavigation($id)
    {
        $subnavigation = NewsSubnavigation::query()
            ->where('id', $id)
            ->get()
            ->first();

        return $subnavigation ? (object) $subnavigation : null;
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
