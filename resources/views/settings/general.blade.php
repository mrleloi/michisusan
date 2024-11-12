<x-manage.container>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 rounded relative mb-4" role="alert" style="top: 30px">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 rounded relative mb-4" role="alert" style="top: 30px">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('setting.general.update') }}" method="post" enctype="multipart/form-data" class="h-full w-full pl-4 md:pl-0 pr-4">
        @csrf
        <h1 class="text-xl font-bold pb-4">一般</h1>

        <div class="border">
            <div class="bg-zinc-200 p-4 flex gap-4">
                <p><span class="text-[#FF0000]">※</span>は入力必須項目です。</p>
            </div>

            <div class="p-4">
                <table class="table-auto w-full border-collapse">
                    <tbody>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                SEOキーワード
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-4">
                                        <input-text name="seo_keyword1" placeholder="キーワード1"
                                            value="{{ old('seo_keyword1', $site->seo_keyword1 ?? '') }}">
                                        </input-text>
                                        <input-text name="seo_keyword2" placeholder="キーワード2"
                                            value="{{ old('seo_keyword2', $site->seo_keyword2 ?? '') }}">
                                        </input-text>
                                        <input-text name="seo_keyword3" placeholder="キーワード3"
                                            value="{{ old('seo_keyword3', $site->seo_keyword3 ?? '') }}">
                                        </input-text>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                SEO付与タイトル
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <input-text name="seo_title" class="w-full" placeholder="SEO付与タイトル"
                                    value="{{ old('seo_title', $site->seo_title ?? '') }}">
                                </input-text>
                                <x-form-error for="seo_title"></x-form-error>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                SEO付与タイトル区切り
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="flex gap-2">
                                    <pv-radio-button name="seo_title_separator" :options='@json($seoTitleSeparators)'
                                        value="{{ old('seo_title_separator', $site->seo_title_separator ?? '') }}">
                                    </pv-radio-button>
                                </div>
                                <x-form-error for="seo_title_separator"></x-form-error>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                コピーライトに表記する文字
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <input-text name="copyright" class="w-full" placeholder="コピーライトに表記する文字"
                                    value="{{ old('copyright', $site->copyright ?? '') }}">
                                </input-text>
                                <x-form-error for="copyright"></x-form-error>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                favicon
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                @if ($site->favicon_image)
                                <div class="flex justify-start items-center gap-2 pb-2">
                                    <img src="/storage/{{ $site->favicon_image }}" class="pb-2 pr-4" style="height: 50px">
                                    <pv-checkbox name="clear_favicon_image"></pv-checkbox>
                                    削除
                                </div>
                                @endif
                                <div class="flex justify-start">
                                    <input type="file" name="favicon_image" value="" class="file-button"></input>
                                </div>
                                <div class="pt-2">
                                    <p>画像形式（拡張子）は『.ico』と『.png』のみ登録できます</p>
                                    <x-form-error for="favicon_image"></x-form-error>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                appleｰtouchｰicon
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                @if ($site->apple_touch_icon_image)
                                <div class="flex justify-start items-center gap-2 pb-2">
                                    <img src="/storage/{{ $site->apple_touch_icon_image }}" class="pb-2 pr-4" style="height: 50px">
                                    <pv-checkbox name="clear_apple_touch_icon_image"></pv-checkbox>
                                    削除
                                </div>
                                @endif
                                <div class="flex justify-start">
                                    <input type="file" name="apple_touch_icon_image" value="" class="file-button"></input>
                                </div>
                                <div class="pt-2">
                                    <p>画像形式（拡張子）は『.png』のみ登録できます</p>
                                    <x-form-error for="apple_touch_icon_image"></x-form-error>
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                wwwの有り無し
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <pv-radio-button name="use_www" :options='@json($wwwPatterns)'
                                    value="{{ old('use_www', $site->use_www ?? '') }}"></pv-radio-button>
                                <x-form-error for="use_www"></x-form-error>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                TOPパンくず表示
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <input-text name="breadcrumb_top" class="w-full" placeholder="TOPパンくず表示"
                                    value="{{ old('breadcrumb_top', $site->breadcrumb_top ?? '') }}">
                                </input-text>
                                <x-form-error for="breadcrumb_top"></x-form-error>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                noindex / nofollow
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <pv-checkbox name="noindex_nofollow"
                                    :value="{{ old('noindex_nofollow', $site->noindex_nofollow ?? 0) }}"></pv-checkbox>
                                設定する
                                <x-form-error for="noindex_nofollow"></x-form-error>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                クッキーポリシーへのリンク配置設定
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="flex gap-2">
                                    <pv-radio-button name="show_link_cookie_policy" :options='@json($cookiePolicies)'
                                        value="{{ old('show_link_cookie_policy', $site->show_link_cookie_policy ?? '') }}"></pv-radio-button>
                                </div>
                                <x-form-error for="show_link_cookie_policy"></x-form-error>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                アクセス制限
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-4">
                                        アカウント: 
                                        <input-text name="account" value="{{ old('account', $site->account ?? '') }}">
                                        </input-text>
                                        パスワード:
                                        <input-text name="password" value="{{ old('password', $site->password ?? '') }}">
                                        </input-text>
                                    </div>
                                </div>
                                <x-form-error for="account"></x-form-error>
                                <x-form-error for="password"></x-form-error>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                robots.txt
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <pv-textarea name="robots_text" value="{{ old('robots_text', $site->robots_text ?? '') }}"
                                    class="w-full h-48"></pv-textarea>
                                <x-form-error for="robots_text"></x-form-error>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                電話番号ボタン除外IP
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <pv-textarea name="exclude_ips" value="{{ old('exclude_ips', $site->exclude_ips ?? '') }}"
                                    class="w-full h-48"></pv-textarea>
                                <p>
                                    【レポート詳細 > 電話番号ボタン】の一覧で対象外にしたいIPアドレスを入力してください<br>
                                    複数のIPアドレスを使用する場合は改行して入力してください
                                </p>
                                <x-form-error for="exclude_ips"></x-form-error>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pt-4 flex gap-4 justify-center">
            <pv-button class="min-w-40" severity="danger" rounded>ダッシュボードに戻る</pv-button>
            <pv-button class="min-w-40" severity="success" rounded type="submit">登録</pv-button>
        </div>
    </form>
</x-manage.container>
