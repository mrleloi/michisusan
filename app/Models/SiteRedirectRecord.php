<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteRedirectRecord extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'slug_source',
        'slug_target',
        'status_code',
        'redirect_start',
        'redirect_end',
    ];

    const STATUS_CODE_301 = 1;
    const STATUS_CODE_302 = 2;

    public static $statusCodeText = [
        self::STATUS_CODE_301 => '301リダイレクト(恒久的な転送)',
        self::STATUS_CODE_302 => '302リダイレクト(一時的な転送)',
    ];

    public function getStatusCodeTextAttribute()
    {
        return self::$statusCodeText[$this->status_code] ?? '';
    }
}
