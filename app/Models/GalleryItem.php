<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryItem extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'gallery_category_id',
        'title',
        'subtitle',
        'summary',
        'description',
        'image_id',
        'link_url',
        'show_button1',
        'button1_link_type',
        'button1_link_page_id',
        'button1_link_page_url',
        'button1_text',
        'button1_link_open_type',
        'show_button2',
        'button2_link_type',
        'button2_link_page_id',
        'button2_link_page_url',
        'button2_text',
        'button2_link_open_type',
        'show_button3',
        'button3_link_type',
        'button3_link_page_id',
        'button3_link_page_url',
        'button3_text',
        'button3_link_open_type',
        'visible',
        'sort_order',
    ];

    public function galleryCategory()
    {
        return $this->belongsTo(GalleryCategory::class);
    }

    public function image() {
        return $this->belongsTo(ImageFile::class, 'image_id');
    }

    public function galleryItemImages(): HasMany
    {
        return $this->hasMany(GalleryItemImage::class);
    }
}
