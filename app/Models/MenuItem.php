<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'name',
        'price',
        'append_wave_dash',
        'tax_type',
        'descro@topm',
        'image1_id',
        'image2_id',
        'image3_id',
        'visible',
        'sort_order',
    ];

    public function menuCategories() {
        return $this->belongsToMany(MenuCategory::class, 'menu_item_categories');
    }

    public function image1() {
        return $this->belongsTo(ImageFile::class, 'image1_id', 'id');
    }
    public function image2() {
        return $this->belongsTo(ImageFile::class, 'image2_id', 'id');
    }
    public function image3() {
        return $this->belongsTo(ImageFile::class, 'image3_id', 'id');
    }
}
