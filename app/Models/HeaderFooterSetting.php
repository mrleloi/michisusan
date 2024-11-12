<?php

namespace App\Models;

use Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderFooterSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tel1',
        'tel1_remarks_top',
        'tel1_remarks_bottom',
        'tel2',
        'tel2_remarks_top',
        'tel2_remarks_bottom',
        'address',
        'business_hours',
        'header_logo_image_id',
        'show_header_translation',
        'show_header_tel1',
        'show_header_tel2',
        'show_header_address',
        'show_header_business_hours',
        'show_header_button',
        'show_pc_header_sns_link',
        'header_button1_link_url',
        'header_button1_alt',
        'header_button1_link_open_type',
        'header_button2_link_url',
        'header_button2_alt',
        'header_button2_link_open_type',
        'header_default_position',
        'header_menu_text_color',
        'header_menu_text_font',
        'header_menu_text_weight',
        'show_bottom_navi',
        'header_menu_text_separator',
        'header_menu_hover_animation',
        'header_menu_hover_animation_text_color',
        'header_menu_hover_animation_bg_color',
        'show_header_menu_sp',
        'sp_header_menu1_link_url',
        'sp_header_menu1_alt',
        'sp_header_menu2_link_url',
        'sp_header_menu2_alt',
        'sp_header_menu3_link_url',
        'sp_header_menu3_alt',
        'sp_header_menu4_link_url',
        'sp_header_menu4_alt',
        'footer_logo_image_id',
        'show_sticky_footer',
        'show_sticky_footer_tel1',
        'show_sticky_footer_tel2',
        'show_sticky_footer_business_hours',
        'show_sticky_footer_button',
        'sticky_footer_button1_link_url',
        'sticky_footer_button1_alt',
        'sticky_footer_button1_link_open_type',
        'sticky_footer_button2_link_url',
        'sticky_footer_button2_alt',
        'sticky_footer_button2_link_open_type',
        'ellipsis_sticky_footer_navi_item',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function headerLogoUrl() {
        $image = ImageFile::find($this->header_logo_image_id);
        return $image ? '/storage/' . $image->filename : '';
    }

    public function footerLogoUrl() {
        $image = ImageFile::find($this->footer_logo_image_id);
        return $image ? '/storage/' . $image->filename : '';
    }

}
