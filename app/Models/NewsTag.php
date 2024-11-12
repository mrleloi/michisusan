<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsTag extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = ['site_id', 'news_article_id', 'tag_id'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }


    public function newsArticle()
    {
        return $this->belongsTo(NewsArticle::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
