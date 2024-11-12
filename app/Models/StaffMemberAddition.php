<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffMemberAddition extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_member_id',
        'sort_order',
        'field_name',
        'contents',
    ];

    public function staffMember(): BelongsTo
    {
        return $this->belongsTo(StaffMember::class);
    }
}
