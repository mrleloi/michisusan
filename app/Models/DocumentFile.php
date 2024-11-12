<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFile extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'filename',
        'filepath',
    ];
}
