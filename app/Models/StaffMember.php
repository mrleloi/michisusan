<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StaffMember extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'department_id',
        'name',
        'another_name',
        'image_id',
        'sort_order',
        'visible',
    ];

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function staffMemberAdditions(): HasMany
    {
        return $this->hasMany(StaffMemberAddition::class);
    }

    public function image() {
        return $this->belongsTo(ImageFile::class);
    }


}
