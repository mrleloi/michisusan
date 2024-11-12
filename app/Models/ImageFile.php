<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageFile extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'filename',
        'thumbnail_filename',
        'image_file_category_id',
        'quality'
    ];

    public function imageFileCategory()
    {
        return $this->belongsTo(ImageFileCategory::class);
    }
}
