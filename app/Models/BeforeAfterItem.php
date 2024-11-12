<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeforeAfterItem extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'title',
        'content',
        'before_after_category_id',
        'before_image_id',
        'after_image_id',
        'visible',
    ];

    public function beforeAfterCategory() {
        return $this->belongsTo(BeforeAfterCategory::class);
    }

    public function beforeImage() {
        return $this->belongsTo(ImageFile::class);
    }

    public function afterImage() {
        return $this->belongsTo(ImageFile::class);
    }

}
