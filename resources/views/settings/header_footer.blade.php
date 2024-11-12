<x-manage.container>
    @props(['items' => [], 'columns' => []])

    <form method="POST" action="{{ route('header_footer.post') }}" class="h-full w-full pl-4 md:pl-0 pr-4">
        @csrf
        <h1 class="text-xl font-bold pb-4">ヘッダー・フッター</h1>

        <div class="border">
            <div class="bg-zinc-200 p-4 flex gap-4">
                <p><span class="text-[#FF0000]">※</span>は入力必須項目です。</p>
            </div>

            <div class="p-4">
                <h1 class="text-xl font-bold pb-4">共通設定</h1>
                <table class="table-auto w-full border-collapse">
                    <tbody>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                電話番号
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-4">
                                        <p>(1)</p>
                                        <input-text name="tel1" value="{{ $setting->tel1 }}"></input-text>
                                        <input-text name="tel1_remarks_top" value="{{ $setting->tel1_remarks_top }}"
                                            placeholder="上部備考"></input-text>
                                        <input-text name="tel1_remarks_bottom" value="{{ $setting->tel1_remarks_bottom }}"
                                            placeholder="下部備考"></input-text>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <p>(2)</p>
                                        <input-text name="tel2" value="{{ $setting->tel2 }}"></input-text>
                                        <input-text name="tel2_remarks_top" value="{{ $setting->tel2_remarks_top }}"
                                            placeholder="上部備考"></input-text>
                                        <input-text name="tel2_remarks_bottom" value="{{ $setting->tel2_remarks_bottom }}"
                                            placeholder="下部備考"></input-text>
                                    </div>

                                    <p>
                                        全ページのヘッダーや追従フッターに表示されます<br>
                                        デザインテンプレートの種類によっては表示されない事があります
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                住所
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <input-text class="w-full" name="address" value="{{ $setting->address }}"></input-text>
                                <p class="text-left pt-4">全ページのヘッダーや追従フッターに表示されます<br>
                                    デザインテンプレートの種類によっては表示されない事があります</p>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                営業時間
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <input-text class="w-full" name="business_hours"
                                    value="{{ $setting->business_hours }}"></input-text>
                                <p class="text-left pt-4">全ページのヘッダーや追従フッターに表示されます<br>
                                    デザインテンプレートの種類によっては表示されない事があります</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                <h1 class="text-xl font-bold pb-4">ヘッダー</h1>
                <setting-table label="ヘッダー" input-id="header" :setting='@json($setting)'
                    :pages='@json($pages)'></setting-table>
            </div>

            <div class="p-4">
                <h1 class="text-xl font-bold pb-4">ヘッダーメニュー</h1>
                <header-menu-setting-table :setting='@json($setting)'
                    :pages='@json($pages)'></header-menu-setting-table>
            </div>

            <div class="p-4">
                <h1 class="text-xl font-bold pb-4">追従フッター</h1>
                <setting-table label="フッター" input-id="sticky_footer" :setting='@json($setting)'
                    :pages='@json($pages)'></setting-table>
            </div>
        </div>

        <div class="pt-4 flex gap-4 justify-center">
            <pv-button class="min-w-40" severity="danger" rounded>ダッシュボードに戻る</pv-button>
            <pv-button class="min-w-40" severity="success" rounded type="submit">登録</pv-button>
        </div>
    </form>
</x-manage.container>
