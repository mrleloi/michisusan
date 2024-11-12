<?php
namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    use SiteMust;

    protected $fillable = [
        'site_id',
        'user_id',
        'user_name',
        'table_name',
        'record_id',
        'page_title',
        'status'
    ];

    // Status constants
    const STATUS_CREATED = 1;
    const STATUS_UPDATED = 2;
    const STATUS_DELETED = 3;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            self::STATUS_CREATED => '新規',
            self::STATUS_UPDATED => '更新',
            self::STATUS_DELETED => '削除',
            default => '(unknown)'
        };
    }
}
