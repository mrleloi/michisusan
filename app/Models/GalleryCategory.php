<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'name',
        'sort_order',
        'visible',
    ];

    public function galleryItems()
    {
        return $this->hasMany(GalleryItem::class);
    }
}
