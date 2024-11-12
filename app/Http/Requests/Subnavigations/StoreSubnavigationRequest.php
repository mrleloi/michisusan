<?php
namespace App\Http\Requests\Subnavigations;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreSubnavigationRequest extends FormRequest
{
    protected $booleanFields = [
        'show_h_translation', 'show_h_tel_1', 'show_h_tel_2', 'show_h_address',
        'show_h_hour', 'show_h_button', 'show_header_sns_on_pc', 'show_smartphone_menus', 'show_f_translation',
        'show_f_tel_1','show_f_tel_2','show_f_address','show_f_hour',
    ];

    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        return back()->withInput()->withErrors($validator);
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Handle checkbox fields (set default if not provided)
        foreach ($this->booleanFields as $field) {
            $this->merge([$field => $this->has($field) ? 1 : 0]);
        }
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'start_page_id' => 'nullable|integer',
            'loading_image' => 'nullable|string|max:255',
            'common_tel_1' => 'nullable|string|max:255',
            'common_tel_1_header_note' => 'nullable|string|max:255',
            'common_tel_1_footer_note' => 'nullable|string|max:255',
            'common_tel_2' => 'nullable|string|max:255',
            'common_tel_2_header_note' => 'nullable|string|max:255',
            'common_tel_2_footer_note' => 'nullable|string|max:255',
            'common_address' => 'nullable|string|max:255',
            'common_hour' => 'nullable|string|max:255',
            'header_logo_image' => 'nullable|string|max:255',
            'show_h_translation' => 'nullable|boolean',
            'show_h_tel_1' => 'nullable|boolean',
            'show_h_tel_2' => 'nullable|boolean',
            'show_h_address' => 'nullable|boolean',
            'show_h_hour' => 'nullable|boolean',
            'show_h_button' => 'nullable|boolean',
            'show_header_sns_on_pc' => 'nullable|boolean',
            'header_btn_1_link_type' => 'nullable|integer|in:1,2',
            'header_btn_1_link01' => 'nullable|integer',
            'header_btn_1_link02' => 'nullable|string|max:255',
            'header_btn_1_text' => 'nullable|string|max:255',
            'header_btn_1_link_target' => 'nullable|integer|in:1,2',
            'header_btn_2_link_type' => 'nullable|integer|in:1,2',
            'header_btn_2_link01' => 'nullable|integer',
            'header_btn_2_link02' => 'nullable|string|max:255',
            'header_btn_2_text' => 'nullable|string|max:255',
            'header_btn_2_link_target' => 'nullable|integer|in:1,2',
            'header_text_align_flag' => 'nullable|integer|in:1,2,3',
            'header_menu_text_color' => 'nullable',
            'header_menu_title_font' => 'nullable|string|max:255',
            'header_menu_body_font' => 'nullable|string|max:255',
            'header_menu_font_weight' => 'nullable|string|max:255',
            'header_menu_divider' => 'nullable|string|max:255',
            'header_menu_hover_animation' => 'nullable|string|max:255',
            'header_menu_hover_text_color' => 'nullable',
            'header_menu_hover_line_color' => 'nullable',
            'show_smartphone_menus' => 'nullable|boolean',
            'footer_logo_image' => 'nullable|string|max:255',
            'show_f_translation' => 'nullable|boolean',
            'show_f_tel_1' => 'nullable|boolean',
            'show_f_tel_2' => 'nullable|boolean',
            'show_f_address' => 'nullable|boolean',
            'show_f_hour' => 'nullable|boolean',
            'footer_btn_1_link_type' => 'nullable|integer|in:1,2',
            'footer_btn_1_link01' => 'nullable|integer',
            'footer_btn_1_link02' => 'nullable|integer',
            'footer_btn_1_text' => 'nullable|string|max:255',
            'footer_btn_1_link_target' => 'nullable|integer|in:1,2,3',
            'footer_btn_2_link_type' => 'nullable|integer|in:1,2',
            'footer_btn_2_link01' => 'nullable|string|max:255',
            'footer_btn_2_link02' => 'nullable|string|max:255',
            'footer_btn_2_text' => 'nullable|string|max:255',
            'footer_btn_2_link_target' => 'nullable|integer|in:1,2',
            'footer_text_align_flag' => 'nullable|integer|in:1,2,3',
            'link_type_menu1' => 'nullable|integer|in:1,2',
            'link01_menu1' => 'nullable|integer',
            'link02_menu1' => 'nullable|string|max:255',
            'url_menu1' => 'nullable|string|max:255',
            'media_menu1' => 'nullable|string|max:255',
            'media_menu1_delete' => 'nullable|integer|in:0,1',
            'text_menu1' => 'nullable|string|max:255',
            'link_type_menu2' => 'nullable|integer|in:1,2',
            'link01_menu2' => 'nullable|integer',
            'link02_menu2' => 'nullable|string|max:255',
            'url_menu2' => 'nullable|string|max:255',
            'media_menu2' => 'nullable|string|max:255',
            'media_menu2_delete' => 'nullable|integer|in:0,1',
            'text_menu2' => 'nullable|string|max:255',
            'link_type_menu3' => 'nullable|integer|in:1,2',
            'link01_menu3' => 'nullable|integer',
            'link02_menu3' => 'nullable|string|max:255',
            'url_menu3' => 'nullable|string|max:255',
            'media_menu3' => 'nullable|string|max:255',
            'media_menu3_delete' => 'nullable|integer|in:0,1',
            'text_menu3' => 'nullable|string|max:255',
            'link_type_menu4' => 'nullable|integer|in:1,2',
            'link01_menu4' => 'nullable|integer',
            'link02_menu4' => 'nullable|string|max:255',
            'url_menu4' => 'nullable|string|max:255',
            'media_menu4' => 'nullable|string|max:255',
            'media_menu4_delete' => 'nullable|integer|in:0,1',
            'text_menu4' => 'nullable|string|max:255',
        ];
    }
}
