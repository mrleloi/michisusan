<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqItem extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'faq_category_id',
        'question',
        'answer',
        'visible',
        'sort_order',
    ];

    public function faqCategory()
    {
        return $this->belongsTo(FaqCategory::class);
    }
}
