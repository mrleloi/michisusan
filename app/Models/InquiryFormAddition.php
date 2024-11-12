<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InquiryFormAddition extends Model
{
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'field_name',
        'field_type',
        'required',
        'contents',
    ];

    public function inquiryForm(): BelongsTo
    {
        return $this->belongsTo(InquiryForm::class);
    }
}
