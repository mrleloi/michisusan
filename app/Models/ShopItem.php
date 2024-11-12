<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopItem extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'name',
        'zip1',
        'zip2',
        'address_type',
        'address1',
        'address2',
        'prefecture',
        'city',
        'town',
        'building',
        'map_type',
        'tel_no',
        'fax_no',
        'description',
        'image_id',
        'sign_logo_image_id',
        'sort_order',
    ];

    public function image() {
        return $this->belongsTo(ImageFile::class);
    }

    public function shopItemAdditions(): HasMany
    {
        return $this->hasMany(ShopItemAddition::class);
    }
}
