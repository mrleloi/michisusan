<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitingSetting extends Model
{
    use HasFactory;
    use SiteMust;

    protected $casts = [
        'navi_menu' => 'json',
        'common_footer' => 'json',
    ];

    protected $fillable = [
        'page_title',
        'description',
        'h1_text',
        'navi_display_name',
        'directory_name',
        'keywords',
        'navi_menu',
        'add_to_site_map',
        'show_sns_on_footer',
        'common_footer',
        'header_image_id',
        'show_header_image',
        'list_design',
        'detail_design',
        'show_detail_page',
        'show_inquiry_button',
        'number_of_items',
        'number_of_articles',
        'category_navi_type',
        'show_all_name',
        'article_order',
        'subnavigation',
        'access_limitation_account',
        'access_limitation_password',
        'original_head_tag',
        'above_title',
        'above_subtitle',
        'above_text',
        'above_titles_position',
        'above_text_position',
        'below_title',
        'below_subtitle',
        'below_text',
        'below_titles_position',
        'below_text_position',
    ];
}
