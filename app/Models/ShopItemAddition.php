<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopItemAddition extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_item_id',
        'sort_order',
        'field_name',
        'contents',
    ];

    public function shopItem(): BelongsTo
    {
        return $this->belongsTo(ShopItem::class);
    }
}
