<?php

namespace App\Models;

use App\Behavior\SiteMust;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InquiryLog extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'received_at',
        'mail_body',
        'user_agent',
        'ip_address',
    ];

    protected $casts = ['received_at' => 'datetime'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y/m/d h:i:s');
    }

    public function inquiryForm(): BelongsTo
    {
        return $this->belongsTo(InquiryForm::class);
    }
}
