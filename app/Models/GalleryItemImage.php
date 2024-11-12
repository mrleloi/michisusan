<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryItemImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_item_id',
        'sort_order',
        'image_id',
    ];

    public function GalleryItem(): BelongsTo
    {
        return $this->belongsTo(GalleryItem::class);
    }
}
