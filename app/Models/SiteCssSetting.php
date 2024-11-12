<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteCssSetting extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'user_id',
        'site_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
