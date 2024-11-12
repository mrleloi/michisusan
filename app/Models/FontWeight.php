<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FontWeight extends Model
{
    protected $table = 'font_weights';

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
