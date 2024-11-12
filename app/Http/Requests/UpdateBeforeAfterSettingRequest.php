<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBeforeAfterSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'page_title' => 'max:35',
            'description' => 'max:250',
            'h1_text' => 'max:35',
            'navi_display_name' => 'max:100',
            'directory_name' => 'required|max:250|regex:/^[0-9a-zA-Z]+$/',
            'keywords' => 'max:250|regex:/^[0-9a-zA-Z,]+$/|nullable',
            'navi_menu' => 'max:20',
            'footer' => 'max:20',
            'header_image_id' => ['exists:image_files,id'],
            'header_image_id_delete' => ['boolean'],
            'show_header_image' => 'boolean',
            'list_design' => 'integer',
            'number_of_items' => '',
            'number_of_articles' => 'boolean',
            'category_navi_type' => 'integer',
            'show_all_name' => 'max:250',
            'article_order' => 'integer',
            'subnavigation' => 'integer',
            'access_limitation_account' => 'max:30',
            'access_limitation_password' => 'max:16',
            'original_head_tag' => '',
            'above_title' => 'max:250',
            'above_subtitle' => 'max:250',
            'above_text' => '',
            'above_titles_position' => 'integer',
            'above_text_position' => 'integer',
            'below_title' => 'max:250',
            'below_subtitle' => 'max:250',
            'below_text' => '',
            'below_titles_position' => 'integer',
            'below_text_position' => 'integer',
        ];
    }
}
