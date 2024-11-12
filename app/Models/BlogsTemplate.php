<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogsTemplate extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'post_id',
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

    public function blogsPosts()
    {
        return $this->hasMany(BlogsPost::class, 'template_id');
    }
}
