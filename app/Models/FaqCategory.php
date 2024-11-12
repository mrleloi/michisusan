<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'name',
        'alias',
        'description',
        'sort_order',
    ];

    public function faqItems()
    {
        return $this->hasMany(FaqItem::class);
    }
}
