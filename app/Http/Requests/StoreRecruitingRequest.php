<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecruitingRequest extends FormRequest
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
            //
            'company_name' => 'required|max:250',
            'url' => '',
            'zip1' => 'nullable|size:3',
            'zip2' => 'nullable|size:4',
            'prefecture' => 'max:100',
            'city' => 'max:100',
            'town' => 'max:100',
            'street_address' => 'max:100',
            'building' => 'max:100',
            'visible' => 'integer',
            'recruiting_category_id' => 'required|integer',
            'title' => 'required|max:250',
            'occupation' => 'required|max:250',
            'job_summary' => 'required|max:250',
            'job_detail' => 'required',
            'wp_zip1' => 'nullable|size:3',
            'wp_zip2' => 'nullable|size:4',
            'wp_prefecture' => 'max:80',
            'wp_city' => 'max:100',
            'wp_town' => 'max:100',
            'wp_street_address' => 'max:100',
            'wp_building' => 'max:100',
            'contact_address' => 'max:250',
            'pic' => 'max:250',
            'employment_status' => 'required|integer',
            'salary_type' => 'required|integer',
            'salary_min' => 'required|integer',
            'salary_max' => 'required|integer',
            'salary_detail' => '',
            'image1_id' => ['exists:image_files,id'],
            'image1_id_delete' => ['boolean'],
            'image1_alt' => 'max:250',
            'image2_id' => ['exists:image_files,id'],
            'image2_id_delete' => ['boolean'],
            'image2_alt' => 'max:250',
            'image3_id' => ['exists:image_files,id'],
            'image3_id_delete' => ['boolean'],
            'image3_alt' => 'max:250',
            'mv_text' => 'integer',
            'button_link_type' => 'integer',
            'button_link_page_id' => 'nullable|integer',
            'button_link_page_url' => '',
            'button_text' => 'max:250',
            'button_link_open_type' => 'integer',
            'sort_order' => 'integer',

            'rows.*' => 'required|array',
            'rows.*.id' => '',
            'rows.*.sort_order' => '',
            'rows.*.field_name' => 'required_with:rows.*.contents|max:80',
            'rows.*.contents' => '',
        ];
    }

    public function attributes(): array
    {
        return [
            'company_name' => '企業名・屋号',
            'url' => 'URL',
            'zip1' => '郵便番号1',
            'zip2' => '郵便番号2',
            'prefecture' => '住所-都道府県',
            'city' => '住所-市町区村',
            'town' => '住所-町域',
            'street_address' => '住所-町域や番地',
            'building' => '住所-建物・ビル名',
            'visible' => '表示設定',
            'recruiting_category_id' => 'カテゴリー',
            'title' => '募集タイトル',
            'occupation' => '募集職種',
            'job_summary' => '仕事内容（概要）',
            'job_detail' => '仕事内容詳細',
            'wp_zip1' => '勤務地‐郵便番号1',
            'wp_zip2' => '勤務地‐郵便番号2',
            'wp_prefecture' => '勤務地‐都道府県',
            'wp_city' => '勤務地‐市町区村',
            'wp_town' => '勤務地‐町域',
            'wp_street_address' => '勤務地‐町域や番地',
            'wp_building' => '勤務地‐建物・ビル名',
            'contact_address' => '連絡先',
            'pic' => '担当者',
            'employment_status' => '雇用形態',
            'salary_type' => '月給',
            'salary_min' => '最低金額',
            'salary_max' => '最高金額',
            'salary_detail' => '給与詳細',
            'image1_id' => '「画像（1）」メディア',
            'image1_alt' => '画像（1）」alt',
            'image2_id' => '「画像（2）」メディア',
            'image2_alt' => '画像（2）」alt',
            'image3_id' => '「画像（3）」メディア',
            'image3_alt' => '画像（3）」alt',
            'mv_text' => 'MV上のテキスト',
            'button_link_type' => 'ボタン設定',
            'button_link_page_id' => 'ボタン設定-リストから選択',
            'button_link_page_url' => 'ボタン設定-直接入力',
            'button_text' => 'ボタン設定-ボタンラベル',
            'button_link_open_type' => 'ボタン設定-開き方',
            'sort_order' => '表示順',

            'rows.*.id' => '自由項目[ID]',
            'rows.*.sort_order' => '自由項目[並び順]',
            'rows.*.field_name' => '自由項目[項目名]',
            'rows.*.contents' => '自由項目[内容]',
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->setValueNames([
            'button1_link_type' => [
                '1' => 'リンクタイプ（サイト内）',
                '2' => 'リンクタイプ（外部リンク）',
            ],
            'button2_link_type' => [
                '1' => 'リンクタイプ（サイト内）',
                '2' => 'リンクタイプ（外部リンク）',
            ],
            'button3_link_type' => [
                '1' => 'リンクタイプ（サイト内）',
                '2' => 'リンクタイプ（外部リンク）',
            ],
        ]);

        return $validator;
    }
}
