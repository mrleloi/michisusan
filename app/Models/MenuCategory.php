<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'name',
        'alias',
        'description',
        'image1_id',
        'image2_id',
        'image3_id',
        'sort_order',
    ];

    public function menuItem() {
        return $this->belongsToMany(MenuItem::class, 'menu_item_categories');
    }
}
