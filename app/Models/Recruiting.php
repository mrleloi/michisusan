<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recruiting extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'company_name',
        'url',
        'zip1',
        'zip2',
        'prefecture',
        'city',
        'town',
        'street_address',
        'building',
        'visible',
        'recruiting_category_id',
        'title',
        'occupation',
        'job_summary',
        'job_detail',
        'wp_zip1',
        'wp_zip2',
        'wp_prefecture',
        'wp_city',
        'wp_town',
        'wp_street_address',
        'wp_building',
        'contact_address',
        'pic',
        'employment_status',
        'salary_type',
        'salary_min',
        'salary_max',
        'salary_detail',
        'image1_id',
        'image1_alt',
        'image2_id',
        'image2_alt',
        'image3_id',
        'image3_alt',
        'mv_text',
        'button_link_type',
        'button_link_page_id',
        'button_link_page_url',
        'button_text',
        'button_link_open_type',
        'sort_order',
    ];

    public function recruitingCategory()
    {
        return $this->belongsTo(RecruitingCategory::class);
    }

    public function recruitingAdditions() : HasMany
    {
        return $this->hasMany(RecruitingAddition::class);
    }

}
