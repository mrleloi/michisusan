<?php

namespace App\Http\Requests\SiteSnsSeting;

use App\Models\SiteSnsSetting;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateSiteSnsSettingRequest extends FormRequest
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
            'icon_design_type' => [
                'required',
                'integer',
                Rule::in([SiteSnsSetting::ICON_DESIGN_TYPE_ROUND, SiteSnsSetting::ICON_DESIGN_TYPE_ROUND_CORNERS])
            ],
            'line_url' => ['nullable', 'url'],
            'line_show_following_part' => ['required', 'boolean'],
            'line_show_pc_header' => ['required', 'boolean'],
            'line_show_sp_header' => ['required', 'boolean'],
            'instagram_url' => ['nullable', 'url'],
            'instagram_show_following_part' => ['required', 'boolean'],
            'instagram_show_pc_header' => ['required', 'boolean'],
            'instagram_show_sp_header' => ['required', 'boolean'],
            'tiktok_url' => ['nullable', 'url'],
            'tiktok_show_following_part' => ['required', 'boolean'],
            'tiktok_show_pc_header' => ['required', 'boolean'],
            'tiktok_show_sp_header' => ['required', 'boolean'],
            'youtube_url' => ['nullable', 'url'],
            'youtube_show_following_part' => ['required', 'boolean'],
            'youtube_show_pc_header' => ['required', 'boolean'],
            'youtube_show_sp_header' => ['required', 'boolean'],
            'facebook_url' => ['nullable', 'url'],
            'facebook_show_following_part' => ['required', 'boolean'],
            'facebook_show_pc_header' => ['required', 'boolean'],
            'facebook_show_sp_header' => ['required', 'boolean'],
            'twitter_url' => ['nullable', 'url'],
            'twitter_show_following_part' => ['required', 'boolean'],
            'twitter_show_pc_header' => ['required', 'boolean'],
            'twitter_show_sp_header' => ['required', 'boolean'],
            'threads_url' => ['nullable', 'url'],
            'threads_show_following_part' => ['required', 'boolean'],
            'threads_show_pc_header' => ['required', 'boolean'],
            'threads_show_sp_header' => ['required', 'boolean'],
            'ameblo_url' => ['nullable', 'url'],
            'ameblo_show_following_part' => ['required', 'boolean'],
            'ameblo_show_pc_header' => ['required', 'boolean'],
            'ameblo_show_sp_header' => ['required', 'boolean'],
            'other1_url' => ['nullable', 'url'],
            'other1_show_following_part' => ['required', 'boolean'],
            'other1_show_pc_header' => ['required', 'boolean'],
            'other1_show_sp_header' => ['required', 'boolean'],
            'other1_image' => ['integer'],
            'other2_url' => ['nullable', 'url'],
            'other2_show_following_part' => ['required', 'boolean'],
            'other2_show_pc_header' => ['required', 'boolean'],
            'other2_show_sp_header' => ['required', 'boolean'],
            'other2_image' => ['integer'],
            'other3_url' => ['nullable', 'url'],
            'other3_show_following_part' => ['required', 'boolean'],
            'other3_show_pc_header' => ['required', 'boolean'],
            'other3_show_sp_header' => ['required', 'boolean'],
            'other3_image' => ['integer'],
        ];
    }

    public function attributes(): array
    {
        return [
            'line_url' => 'LINE URL',
            'instagram_url' => 'Instagram URL',
            'tiktok_url' => 'TikTok URL',
            'youtube_url' => 'YouTube URL',
            'facebook_url' => 'Facebook URL',
            'twitter_url' => 'X（Twitter） URL',
            'threads_url' => 'Threads URL',
            'ameblo_url' => 'ブログ URL',
            'other1_url' => 'その他1 URL',
            'other2_url' => 'その他2 URL',
            'other3_url' => 'その他3 URL',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return back()->withInput()->withErrors($validator);
    }
}
