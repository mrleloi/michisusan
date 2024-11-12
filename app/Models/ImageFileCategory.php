<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageFileCategory extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'name',
    ];

    public function imageFile()
    {
        return $this->hasMany(ImageFile::class);
    }
}
