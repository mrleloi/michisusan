<?php

// app/Models/PhoneCall.php
namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhoneCallLog extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'page_title',
        'page_location',
        'page_path',
        'button_position',
        'phone_number',
        'access_ip',
        'user_agent',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
