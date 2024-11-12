<?php

namespace App\Http\Controllers;

use App\Services\HeaderFooterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    protected $headerFooterService;

    public function __construct(
        HeaderFooterService $headerFooterService
    ) {
        $this->headerFooterService = $headerFooterService;
    }

    public function header_footer(Request $request) {
        $setting = $this->headerFooterService->findBySiteId(1);
        return view('settings.header_footer', [
            'setting' => $setting,
            'pages' => $this->headerFooterService->getPages(1)
        ]);
    }

    public function header_footer_update(Request $request) {
        $this->headerFooterService->update(1, $request->validate([
            'tel1' => 'nullable',
            'tel1_remarks_top' => 'nullable',
            'tel1_remarks_bottom' => 'nullable',
            'tel2' => 'nullable',
            'tel2_remarks_top' => 'nullable',
            'tel2_remarks_bottom' => 'nullable',
            'address' => 'nullable',
            'business_hours' => 'nullable',
            'header_logo_image_id' => 'int',
            'show_header_translation' => 'boolean',
            'show_header_tel1' => 'boolean',
            'show_header_tel2' => 'boolean',
            'show_header_address' => 'boolean',
            'show_header_business_hours' => 'boolean',
            'show_header_button' => 'boolean',
            'show_pc_header_sns_link' => 'boolean',
            'header_button1_link_url' => 'nullable',
            'header_button1_alt' => 'nullable',
            'header_button1_link_open_type' => 'nullable',
            'header_button2_link_url' => 'nullable',
            'header_button2_alt' => 'nullable',
            'header_button2_link_open_type' => 'nullable',
            'header_default_position' => 'nullable',
            'header_menu_text_color' => 'nullable',
            'header_menu_text_font' => 'nullable',
            'header_menu_text_weight' => 'nullable',
            'show_bottom_navi' => 'boolean',
            'header_menu_text_separator' => 'nullable',
            'header_menu_hover_animation' => 'nullable',
            'header_menu_hover_animation_text_color' => 'nullable',
            'header_menu_hover_animation_bg_color' => 'nullable',
            'show_header_menu_sp' => 'boolean',
            'sp_header_menu1_link_url' => 'nullable',
            'sp_header_menu1_alt' => 'nullable',
            'sp_header_menu2_link_url' => 'nullable',
            'sp_header_menu2_alt' => 'nullable',
            'sp_header_menu3_link_url' => 'nullable',
            'sp_header_menu3_alt' => 'nullable',
            'sp_header_menu4_link_url' => 'nullable',
            'sp_header_menu4_alt' => 'nullable',
            'footer_logo_image_id' => 'int',
            'show_sticky_footer' => 'boolean',
            'show_sticky_footer_tel1' => 'boolean',
            'show_sticky_footer_tel2' => 'boolean',
            'show_sticky_footer_business_hours' => 'boolean',
            'show_sticky_footer_button' => 'boolean',
            'sticky_footer_button1_link_url' => 'nullable',
            'sticky_footer_button1_alt' => 'nullable',
            'sticky_footer_button1_link_open_type' => 'nullable',
            'sticky_footer_button2_link_url' => 'nullable',
            'sticky_footer_button2_alt' => 'nullable',
            'sticky_footer_button2_link_open_type' => 'nullable',
            'ellipsis_sticky_footer_navi_item' => 'nullable',
        ]));
        return Redirect::route('header_footer.index');
    }
}
