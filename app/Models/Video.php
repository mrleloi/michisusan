<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'filename',
        'thumbnail_filename',
        'video_category_id'
    ];

    public function videoCategory()
    {
        return $this->belongsTo(VideoCategory::class);
    }
}
