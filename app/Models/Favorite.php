<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'name',
        'favorite_category_id',
        'sort_order',
    ];

    public function favoriteCategory(){
        return $this->belongsTo(FavoriteCategory::class);
    }
}
