<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;

class RecruitingCategory extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'name',
        'alias',
        'sort_order'
    ];

    public function recruitings()
    {
        return $this->hasMany(Recruiting::class);
    }
}
