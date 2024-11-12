<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'name',
    ];

    public function video()
    {
        return $this->hasMany(Video::class);
    }
}
