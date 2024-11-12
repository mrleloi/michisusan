<?php

namespace App\Models;

use App\Behavior\HasOrder;
use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    use SiteMust;
    use HasOrder;

    protected $fillable = ['site_id', 'name', 'description_top', 'description_bottom', 'show_description', 'h1_text', 'publish_status', 'order'];

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

    const SHOW_DESCRIPTION_YES = 1;
    const SHOW_DESCRIPTION_NO = 0;

    public function site()
    {
        return $this->belongsTo(Site::class);
    }


    public function newsTags()
    {
        return $this->belongsTo(NewsTag::class);
    }

    public function blogsTags()
    {
        return $this->hasOne(BlogsTag::class);
    }
}
