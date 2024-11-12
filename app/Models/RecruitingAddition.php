<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecruitingAddition extends Model
{
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'field_name',
        'contents',
    ];

    public function recruiting(): BelongsTo
    {
        return $this->belongsTo(Recruiting::class);
    }
}
