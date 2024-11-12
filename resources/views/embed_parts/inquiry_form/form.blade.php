@push('styles')
    @vite('resources/css/table.css')

    <style>
        .w-full-password input {
            width: 100%;
        }

        .tab-wrap {
            display: flex;
            flex-wrap: wrap;
        }

        .tab-label {
            color: #6b7280;
            background: transparent;
            font-weight: bold;
            white-space: nowrap;
            text-align: center;
            padding: 1rem 1.5rem;
            order: -1;
            position: relative;
            z-index: 1;
            cursor: pointer;
            font-size: 1.1rem;
            border-bottom: 3px solid #e5e7eb;
        }

        .tab-content {
            width: 100%;
            height: 0;
            padding-top: 1rem;
            overflow: hidden;
            opacity: 0;
        }

        /* アクティブなタブ */
        .tab-switch:checked+.tab-label {
            color: #4789f6;
            border-bottom: 3px solid #3b82f6;
        }

        .tab-switch:checked+.tab-label+.tab-content {
            height: auto;
            overflow: auto;
            opacity: 1;
            transition: .5s opacity;
        }

        /* ラジオボタン非表示 */
        .tab-switch {
            display: none;
        }
    </style>
@endpush
<div class="border">
    <div class="bg-zinc-200 p-4">
        <span class="text-red-500">※</span>は必須項目です
    </div>
    <div class="tab-wrap p-5">
        <input id="tab-01" type="radio" name="tab" class="tab-switch" checked="checked" />
        <label class="tab-label" for="tab-01">フォーム設定</label>
        <div class="tab-content">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th>フォーム名<span class="text-red-500">※</span></th>
                        <td> <input-text name="form_name" class="w-full" placeholder="ページに表示されます。20文字以内で入力してください"
                                value="{{ old('form_name', $inquiryForm->form_name ?? '') }}"></input-text>
                            <x-form-error for="form_name"></x-form-error>
                        </td>
                    </tr>
                    <tr>
                        <th>フォーム説明<span class="text-red-500">※</span></th>
                        <td>
                            <pv-textarea name="form_description" class="w-full" placeholder="ホームページ上に表示されます"
                                rows="6"
                                value="{{ old('form_description', $inquiryForm->form_description ?? '') }}">
                            </pv-textarea>
                            <x-form-error for="form_description"></x-form-error>
                        </td>
                    </tr>
                    <tr>
                        <th>受信用メールアドレス<span class="text-red-500">※</span></th>
                        <td> <input-text name="dest_mailaddress" class="w-full" placeholder="メール送信先アドレスを設定してください"
                                value="{{ old('dest_mailaddress', $inquiryForm->dest_mailaddress ?? '') }}"></input-text>
                            <x-form-error for="dest_mailaddress"></x-form-error>
                        </td>
                    </tr>
                    <tr>
                        <th>送信元メールアドレス<span class="text-red-500">※</span></th>
                        <td> <input-text name="from_mailaddress" class="w-full" placeholder="自動返信メールの送信元として表示されます"
                                value="{{ old('from_mailaddress', $inquiryForm->from_mailaddress ?? '') }}"></input-text>
                            <x-form-error for="from_mailaddress"></x-form-error>
                        </td>
                    </tr>
                    <tr>
                        <th>プライバシーポリシー</th>
                        <td> <input-text name="privacy_policy" class="w-full" placeholder="メール送信先アドレスを設定してください"
                                value="{{ old('privacy_policy', $inquiryForm->privacy_policy ?? '') }}"></input-text>
                            <x-form-error for="privacy_policy"></x-form-error>
                        </td>
                    </tr>
                    <tr>
                        <th>送信完了メッセージ</th>
                        <td>
                            <ck-editor name="question" class="w-full"
                                value="{{ old('finish_message', $inquiryForm->finish_message ?? '') }}">
                            </ck-editor>
                            <x-form-error for="finish_message"></x-form-error>
                        </td>
                    </tr>
                    <tr>
                        <th>管理者宛：件名<span class="text-red-500">※</span></th>
                        <td> <input-text name="for_admin_title" class="w-full" placeholder="受信用メールアドレスに届くメールの件名です"
                                value="{{ old('for_admin_title', $inquiryForm->for_admin_title ?? '') }}"></input-text>
                            <x-form-error for="for_admin_title"></x-form-error>
                        </td>
                    </tr>

                    <tr>
                        <th>管理者宛：本文</th>
                        <td>
                            <pv-textarea name="for_admin_body" class="w-full" placeholder="ホームページ上に表示されます"
                                rows="6" value="{{ old('for_admin_body', $inquiryForm->for_admin_body ?? '') }}">
                            </pv-textarea>
                            <x-form-error for="for_admin_body"></x-form-error>
                        </td>
                    </tr>

                    <tr>
                        <th>ユーザ宛：件名<span class="text-red-500">※</span></th>
                        <td> <input-text name="for_user_title" class="w-full" placeholder="自動返信メールの件名です"
                                value="{{ old('for_user_title', $inquiryForm->for_user_title ?? '') }}"></input-text>
                            <x-form-error for="for_user_title"></x-form-error>
                        </td>
                    </tr>

                    <tr>
                        <th>ユーザー宛：本文</th>
                        <td>
                            <pv-textarea name="for_user_body" class="w-full" placeholder="自動返信メールの送信確認メールの本文です"
                                rows="6" value="{{ old('for_user_body', $inquiryForm->for_user_body ?? '') }}">
                            </pv-textarea>
                            <x-form-error for="for_user_body"></x-form-error>
                        </td>
                    </tr>
                    <tr>
                        <th>ユーザー宛：署名</th>
                        <td>
                            <pv-textarea name="for_user_signature" class="w-full" placeholder="メールの本文下部に表示される署名です"
                                rows="6"
                                value="{{ old('for_user_signature', $inquiryForm->for_user_signature ?? '') }}">
                            </pv-textarea>
                            <x-form-error for="for_user_signature"></x-form-error>
                        </td>
                    </tr>

                    <tr>
                        <th>Reply-to</th>
                        <td>
                            <pv-checkbox name="add_user_to_reply_to"
                                :value="{{ old('add_user_to_reply_to', $inquiryForm->add_user_to_reply_to ?? 0) }}"></pv-checkbox><span
                                class="ml-5">Reply-Toにユーザーメールを含める</span>
                        </td>
                    </tr>

                    <tr>
                        <th>コンバージョンタグ(1)</th>
                        <td>
                            <pv-textarea name="conversion_tag1" class="w-full" rows="6"
                                value="{{ old('conversion_tag1', $inquiryForm->conversion_tag1 ?? '') }}">
                            </pv-textarea>
                            <p class="mt-2">フォームの送信完了画面に埋め込まれます</p>
                            <x-form-error for="conversion_tag1"></x-form-error>
                        </td>
                    </tr>
                    <tr>
                        <th>コンバージョンタグ(2)</th>
                        <td>
                            <pv-textarea name="conversion_tag2" class="w-full" rows="6"
                                value="{{ old('conversion_tag2', $inquiryForm->conversion_tag2 ?? '') }}">
                            </pv-textarea>
                            <p class="mt-2">フォームの送信完了画面の『body閉じタグ』直前に埋め込まれます</p>
                            <x-form-error for="conversion_tag2"></x-form-error>
                        </td>
                    </tr>
                    <tr>
                        <th>コンバージョンタグ(3)</th>
                        <td>
                            <pv-textarea name="conversion_tag3" class="w-full" rows="6"
                                value="{{ old('conversion_tag3', $inquiryForm->conversion_tag3 ?? '') }}">
                            </pv-textarea>
                            <p class="mt-2">フォームの送信完了画面の『head開始タグ』直前に埋め込まれます</p>
                            <x-form-error for="conversion_tag3"></x-form-error>
                        </td>
                    </tr>
                    <tr>
                        <th>備考の表記方法</th>
                        <td>
                            <div class="flex flex-wrap gap-x-24">
                                <pv-radio-button name="remark_type" :options='@json($remarkTypeOptions)'
                                    :value="{{ intval(old('remark_type', $inquiryForm->remark_type ?? null)) }}"></pv-radio-button>
                            </div>
                            <x-form-error for="remark_type"></x-form-error>
                        </td>
                    </tr>
                    <tr>
                        <th>未入力・未選択項目</th>
                        <td><pv-checkbox name="ignore_unspecified"
                                :value="{{ old('ignore_unspecified', $inquiryForm->ignore_unspecified ?? 0) }}"></pv-checkbox><span
                                class="ml-5">未入力・未選択項目はメールに記載しない</span>
                            <x-form-error for="ignore_unspecified"></x-form-error>
                        </td>
                    </tr>

                    <tr>
                        <th>除外IPアドレス</th>
                        <td>
                            <pv-textarea name="ignore_ip" class="w-full" rows="6"
                                value="{{ old('ignore_ip', $inquiryForm->ignore_ip ?? '') }}">
                            </pv-textarea>
                            <p class="mt-2">スパムメール対策等、受信を拒否したいIPアドレスを入力してください<br>
                                複数のIPアドレスを指定する場合は開業して入力してください</p>
                            <x-form-error for="ignore_ip"></x-form-error>
                        </td>
                    </tr>

                    <tr>
                        <th>Google reCAPTCHA v3</th>
                        <td>
                            <div class="flex flex-wrap">
                                <label class="w-full">サイトキー</label>
                                <input-text name="recaptcha_site_key" class="w-full" placeholder="サイトキー"
                                    value="{{ old('recaptcha_site_key', $inquiryForm->recaptcha_site_key ?? '') }}"></input-text>
                                <x-form-error for="recaptcha_site_key"></x-form-error>
                                <label class="w-full">シークレットキー</label>
                                <input-text name="recaptcha_secret_key" class="w-full" placeholder="シークレットキー"
                                    value="{{ old('recaptcha_secret_key', $inquiryForm->recaptcha_secret_key ?? '') }}"></input-text>
                                <x-form-error for="recaptcha_secret_key"></x-form-error>
                            </div>
                            <p class="mt-2">Google reCAPTCHA v3 を導入したい場合のみ、<br>
                                サイトキーとシークレットキーの両方を入力してください</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input id="tab-02" type="radio" name="tab" class="tab-switch" />
        <label class="tab-label" for="tab-02">メールオプション</label>
        <div class="tab-content">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th>SMTP認証設定</th>
                        <td>
                            <div class="flex flex-wrap">
                                <label class="w-full mt-2">アカウント名</label>
                                <input-text name="smtp_account_name" class="w-full"
                                    value="{{ old('smtp_account_name', $inquiryForm->smtp_account_name ?? '') }}"></input-text>
                                <x-form-error for="smtp_account_name"></x-form-error>
                                <label class="w-full mt-2">パスワード</label>
                                <password name="smtp_password" class="w-full w-full-password" :feedback="false" :input-props='{autocomplete: "new-password"}'
                                    value="{{ old('smtp_password', $inquiryForm->smtp_password ?? '') }}"></password>
                                <x-form-error for="smtp_password"></x-form-error>
                                <label class="w-full mt-2">SMTPサーバー</label>
                                <input-text name="smtp_server" class="w-full"
                                    value="{{ old('smtp_server', $inquiryForm->smtp_server ?? '') }}"></input-text>
                                <x-form-error for="smtp_server"></x-form-error>
                                <label class="w-full mt-2">SMTPポート番号</label>
                                <input-text name="smtp_port_number" class="w-full"
                                    value="{{ old('smtp_port_number', $inquiryForm->smtp_port_number ?? '') }}"></input-text>
                                <x-form-error for="smtp_port_number"></x-form-error>
                            </div>
                            <p class="mt-2">未入力の場合はサーバー上のシステムから送信を試みます<br>
                                正常に受信できない場合、こちらに入力されたSMTPサーバー経由で送信を試みます<br>
                                『送信元メールアドレス』のSMTP認証情報をご入力くださ
                                SMTPサーバ経由で送信を試みる場合は、全ての項目を入力してください</p>
                        </td>
                    </tr>
                    <tr>
                        <th>送信テスト</th>
                        <td>
                            <mail-test-button></mail-test-button>
                            <div class="mt-2 text-red-500">
                                ※送信テストの結果表示には数秒〜数十秒かかります。
                                <p class="indent-3"> ボタンの連打等を行うとメールサーバ側にSPAM行為とみなされ、 </p>
                                <p class="indent-3"> メールアドレス自体が使用不可になる可能性もありますのでご注意ください。 </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input id="tab-03" type="radio" name="tab" class="tab-switch" />
        <label class="tab-label" for="tab-03">入力項目設定</label>
        <div class="tab-content">
            <inquiry-form-fields :fields="@js(old('rows', $inquiryFormFields ?? []))" :field-type-options="@js($fieldTypeOptions)"
                :errors="@js($errors->toArray())">
            </inquiry-form-fields>
        </div>
    </div>
</div>
