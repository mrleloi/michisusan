<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTemplate extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'article_id',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function newsArticles()
    {
        return $this->hasMany(NewsArticle::class, 'template_id');
    }
}
