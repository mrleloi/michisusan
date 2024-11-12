<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Models;

use App\Behavior\HasOrder;
use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsCategory extends Model
{
    use HasFactory;
    use SiteMust;
    use HasOrder;

    protected $fillable = ['site_id', 'name', 'description_heading', 'description_top', 'description_bottom', 'show_description', 'h1_text', 'seleted_text', 'link_type', 'link_page_id', 'link_url', 'link_open_type', 'publish_status', 'order'];

    const STATUS_UNPUBLISHED = 0;
    const STATUS_PUBLISHED = 1;
    public static $publishStatusText = [
        self::STATUS_UNPUBLISHED => '非公開',
        self::STATUS_PUBLISHED => '公開',
    ];

    const SHOW_DESCRIPTION_YES = 1;
    const SHOW_DESCRIPTION_NO = 0;

    const LINK_TYPE_NO_DISPLAY = 1;
    const LINK_TYPE_INTERNAL = 2;
    const LINK_TYPE_EXTERNAL = 3;

    const LINK_OPEN_SAME_WINDOW = 1;
    const LINK_OPEN_NEW_WINDOW = 2;

    public function getPublishStatusTextAttribute()
    {
        return self::$publishStatusText[$this->publish_status] ?? '不明';
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function articles()
    {
        return $this->belongsToMany(NewsArticle::class, 'news_article_category', 'news_category_id', 'news_article_id');
    }

    public function page()
    {
        return $this->hasOne(Page::class, 'link_page_id', 'id');
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
