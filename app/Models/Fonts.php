<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fonts extends Model
{
    protected $table = 'fonts';

    protected $fillable = [
        'site_id',
        'code',
        'name',
        'value',
        'status',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
}
