<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteJsSetting extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'user_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
