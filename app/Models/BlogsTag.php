<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogsTag extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = ['site_id', 'blogs_post_id', 'tag_id'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }


    public function blogsPost()
    {
        return $this->belongsTo(BlogsPost::class);
    }


    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
