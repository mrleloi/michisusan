<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'name',
        'alias',
        'description',
        'sort_order',
    ];

    public function staffMembers() {
        return $this->hasMany(StaffMember::class);
    }
}
