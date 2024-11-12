<?php

namespace App\Models;

use App\Behavior\SiteMust;
use App\Casts\SiteSnsSetting\SnsImageCast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSnsSetting extends Model
{
    use HasFactory;
    use SiteMust;

    public const ICON_DESIGN_TYPE_ROUND = 1;
    public const ICON_DESIGN_TYPE_ROUND_CORNERS = 2;

    protected $fillable = [
        'id',
        'site_id',
        'icon_design_type',
        'line_url',
        'line_show_following_part',
        'line_show_pc_header',
        'line_show_sp_header',
        'instagram_url',
        'instagram_show_following_part',
        'instagram_show_pc_header',
        'instagram_show_sp_header',
        'tiktok_url',
        'tiktok_show_following_part',
        'tiktok_show_pc_header',
        'tiktok_show_sp_header',
        'youtube_url',
        'youtube_show_following_part',
        'youtube_show_pc_header',
        'youtube_show_sp_header',
        'facebook_url',
        'facebook_show_following_part',
        'facebook_show_pc_header',
        'facebook_show_sp_header',
        'twitter_url',
        'twitter_show_following_part',
        'twitter_show_pc_header',
        'twitter_show_sp_header',
        'threads_url',
        'threads_show_following_part',
        'threads_show_pc_header',
        'threads_show_sp_header',
        'ameblo_url',
        'ameblo_show_following_part',
        'ameblo_show_pc_header',
        'ameblo_show_sp_header',
        'other1_url',
        'other1_show_following_part',
        'other1_show_pc_header',
        'other1_show_sp_header',
        'other1_image',
        'other2_url',
        'other2_show_following_part',
        'other2_show_pc_header',
        'other2_show_sp_header',
        'other2_image',
        'other3_url',
        'other3_show_following_part',
        'other3_show_pc_header',
        'other3_show_sp_header',
        'other3_image',
    ];

    protected function casts(): array
    {
        return [
            'other1_image' => SnsImageCast::class,
            'other2_image' => SnsImageCast::class,
            'other3_image' => SnsImageCast::class,
        ];
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
