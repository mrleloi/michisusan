<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryFormRequest extends FormRequest
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
            'form_name' => 'max:20|required',
            'form_description' => '',
            'dest_mailaddress' => 'email',
            'from_mailaddress' => 'email',
            'privacy_policy' => '',
            'finish_message' => '',
            'for_admin_title' => 'max:250',
            'for_admin_body' => '',
            'for_user_title' => 'max:250',
            'for_user_body' => '',
            'for_user_signature' => '',
            'add_user_to_reply_to' => 'boolean',
            'conversion_tag1' => '',
            'conversion_tag2' => '',
            'conversion_tag3' => '',
            'remark_type' => 'integer',
            'ignore_unspecified' => 'boolean',
            'ignore_ip' => '',
            'recaptcha_site_key' => 'max:40',
            'recaptcha_secret_key' => 'max:40',
            'smtp_account_name' => 'max:100',
            'smtp_password' => 'max:64',
            'smtp_server' => 'max:255',
            'smtp_port_number' => ['nullable', 'integer'],

            'rows.*' => 'required|array',
            'rows.*.id' => '',
            'rows.*.sort_order' => '',
            'rows.*.field_name' => 'required_with:rows.*.contents,rows.*.field_type|max:80',
            'rows.*.field_type' => 'nullable|integer',
            'rows.*.required' => '',
            'rows.*.contents' => '',
            'rows.*.remarks' => '',
        ];
    }

    public function attributes(): array
    {
        return [
            'form_name' => 'フォーム名',
            'form_description' => 'フォーム説明',
            'dest_mailaddress' => '受信用メールアドレス',
            'from_mailaddress' => '送信用メールアドレス',
            'privacy_policy' => 'プライバシーポリシー',
            'finish_message' => '送信完了メッセージ',
            'for_admin_title' => '管理者宛：件名',
            'for_admin_body' => '管理者宛：本文',
            'for_user_title' => 'ユーザー宛：麺名',
            'for_user_body' => 'ユーザー宛：本文',
            'for_user_signature' => 'ユーザー宛：署名',
            'add_user_to_reply_to' => 'ReplyTo',
            'conversion_tag1' => 'コンバージョンタグ(1)',
            'conversion_tag2' => 'コンバージョンタグ(2)',
            'conversion_tag3' => 'コンバージョンタグ(3)',
            'remark_type' => '備考の表記方法',
            'ignore_unspecified' => '未入力・未選択項目',
            'ignore_ip' => '除外IPアドレス',
            'recaptcha_site_key' => 'Google reCAPTCHA v3 サイトキー',
            'recaptcha_secret_key' => 'Google reCAPTCHA v3 シークレットキー',
            'smtp_account_name' => 'SMTPアカウント名',
            'smtp_password' => 'SMTPパスワード',
            'smtp_server' => 'SMTPサーバー',
            'smtp_port_number' => 'SMTPポート番号',

            'rows.*.id' => '入力項目設定[ID]',
            'rows.*.sort_order' => '入力項目設定[並び順]',
            'rows.*.field_name' => '入力項目設定[項目名]',
            'rows.*.field_type' => '入力項目設定[タイプ]',
            'rows.*.required' => '入力項目設定[必須]',
            'rows.*.contents' => '入力項目設定[内容]',
            'rows.*.remarks' => '入力項目設定[備考]',
        ];
    }
}
