<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subnavigation extends Model
{
    use HasFactory;
    use SiteMust;

    protected $table = 'subnavigations';

    protected $fillable = [
        'site_id',
        'name',
        'start_page_id',
        'loading_image',
        'common_tel_1',
        'common_tel_1_header_note',
        'common_tel_1_footer_note',
        'common_tel_2',
        'common_tel_2_header_note',
        'common_tel_2_footer_note',
        'common_address',
        'common_hour',
        'header_logo_image',
        'show_h_translation',
        'show_h_tel_1',
        'show_h_tel_2',
        'show_h_address',
        'show_h_hour',
        'show_h_button',
        'show_header_sns_on_pc',
        'header_btn_1_link_type',
        'header_btn_1_link01',
        'header_btn_1_link02',
        'header_btn_1_text',
        'header_btn_1_link_target',
        'header_btn_2_link_type',
        'header_btn_2_link01',
        'header_btn_2_link02',
        'header_btn_2_text',
        'header_btn_2_link_target',
        'header_text_align_flag',
        'header_menu_text_color',
        'header_menu_title_font',
        'header_menu_body_font',
        'header_menu_font_weight',
        'header_menu_divider',
        'header_menu_hover_animation',
        'header_menu_hover_text_color',
        'header_menu_hover_line_color',
        'show_smartphone_menus',
        'footer_logo_image',
        'show_f_translation',
        'show_f_tel_1',
        'show_f_tel_2',
        'show_f_address',
        'show_f_hour',
        'footer_btn_1_link_type',
        'footer_btn_1_link01',
        'footer_btn_1_link02',
        'footer_btn_1_text',
        'footer_btn_1_link_target',
        'footer_btn_2_link_type',
        'footer_btn_2_link01',
        'footer_btn_2_link02',
        'footer_btn_2_text',
        'footer_btn_2_link_target',
        'footer_text_align_flag'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function subnavigationSmartphoneMenus() {
        return $this->hasMany(SubnavigationSmartphoneMenu::class);
    }
}
