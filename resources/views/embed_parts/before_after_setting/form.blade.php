@push('styles')
    @vite('resources/css/table.css')
@endpush
<div class="border">
    <div class="bg-zinc-200 p-4">
        <span class="text-red-500">※</span>は必須項目です
    </div>
    <div class="p-4">
        <h2 class="text-xl font-bold mb-2">タイトル・ディスクリプション・ｈ１テキスト</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th>ページタイトル</th>
                    <td>
                        <input-text-with-count name="page_title" class="w-full" :maxlength="35"
                            value="{{ old('page_title', $beforeAfterSetting->page_title ?? '') }}"></input-text-with-count>
                        <x-form-error for="page_title"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>description</th>
                    <td>
                        <input-text-with-count name="description" class="w-full" :maxlength="250"
                            value="{{ old('description', $beforeAfterSetting->description ?? '') }}"></input-text-with-count>
                        <x-form-error for="description"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>ｈ１テキスト</th>
                    <td>
                        <input-text-with-count name="h1_text" class="w-full" :maxlength="35"
                            value="{{ old('h1_text', $beforeAfterSetting->h1_text ?? '') }}"></input-text-with-count>
                        <x-form-error for="h1_text"></x-form-error>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2 class="text-xl font-bold mt-5 mb-2">基本設定</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th>ナビ表示名</th>
                    <td>
                        <input-text name="navi_display_name" class="w-full"
                            value="{{ old('navi_display_name', $beforeAfterSetting->navi_display_name ?? '') }}"></input-text>
                        <x-form-error for="navi_display_name"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>ディレクトリ名<span class="text-red-500">※</span></th>
                    <td>
                        <input-text name="directory_name" class="w-full"
                            value="{{ old('directory_name', $beforeAfterSetting->directory_name ?? '') }}"></input-text>
                        <x-form-error for="directory_name"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>keywords</th>
                    <td>
                        <input-text name="keywords" class="w-full"
                            value="{{ old('keywords', $beforeAfterSetting->keywords ?? '') }}"></input-text>
                        <x-form-error for="keywords"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>ナビメニュー</th>
                    <td>
                        <div class="flex flex-wrap gap-y-5">
                            @foreach ($naviMenuTypes as $naviMenuType)
                                <div class="w-80">
                                    <pv-checkbox name="navi_menu[{{ $naviMenuType['key'] }}]"
                                        :value="{{ old('navi_menu.' . $naviMenuType['key'], Arr::get($beforeAfterSetting, 'navi_menu.' . $naviMenuType['key']) ?? 0) }}"></pv-checkbox><span
                                        class="ml-5">{{ $naviMenuType['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                        <x-form-error for="navi_menu"></x-form-error>
                        <p class="mt-3">上部メニュー、下部メニューへの表示設定です</p>
                    </td>
                </tr>
                <tr>
                    <th>フッター</th>
                    <td>
                        <div class="flex flex-wrap gap-y-5">
                            @foreach ($footerTypes as $footerType)
                                <div class="w-80">
                                    <pv-checkbox name="footer[{{ $footerType['key'] }}]"
                                        :value="{{ old('footer.' . $footerType['key'], Arr::get($beforeAfterSetting, 'footer.' . $footerType['key']) ?? 0) }}"></pv-checkbox><span
                                        class="ml-5">{{ $footerType['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                        <x-form-error for="footer"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>見出し画像</th>
                    <td>
                        <image-selector name="header_image_id"
                            value="{{ old('header_image_id', $beforeAfterSetting->header_image_id ?? '') }}"></image-selector>
                        <x-form-error for="header_image_id"></x-form-error>
                        <p class="mt-3">推奨サイズは横1920px以上、横360px以上です</p>
                    </td>
                </tr>
                <tr>
                    <th>見出し画像の表示</th>
                    <td>
                        <div class="flex flex-wrap">
                            <pv-radio-button name="show_header_image" :options="@js($visibleOptions)"
                                value="{{ old('show_header_image', $beforeAfterSetting->show_header_image ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="show_header_image"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>一覧デザイン</th>
                    <td>
                        <div class="flex flex-wrap max-w-[640px] gap-x-10">
                            <radio-button-with-image name="list_design" :options="@js($listlDesignTypes)"
                                value="{{ old('list_design', $beforeAfterSetting->list_design ?? '1') }}">
                            </radio-button-with-image>
                        </div>
                        <x-form-error for="list_design"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>表示件数</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-select name="number_of_items" :options="@js($numberOfItemsTypes)" class="w-full"
                                option-label="label" option-value="key"
                                value="{{ old('number_of_items', $beforeAfterSetting->number_of_items ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="number_of_items"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>記事数</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="number_of_articles" :options="@js($visibleOptions)"
                                value="{{ old('number_of_articles', $beforeAfterSetting->number_of_articles ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="number_of_articles"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>カテゴリナビ</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="category_navi_type" :options="@js($categoryNaviTypes)"
                                value="{{ old('category_navi_type', $beforeAfterSetting->category_navi_type ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="category_navi_type"></x-form-error>
                        <p class="mt-3">「表示しない」を選択すると１カラムで表示されます</p>
                    </td>
                </tr>
                <tr>
                    <th>全件表示時の名称</th>
                    <td>
                        <input-text name="show_all_name" class="w-full"
                            value="{{ old('show_all_name', $beforeAfterSetting->show_all_name ?? '') }}"></input-text>
                        <x-form-error for="show_all_name"></x-form-error>
                        <p class="mt-3">カテゴリナビを表示する場合に適用されます</p>
                    </td>
                </tr>
                <tr>
                    <th>記事の並び順</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="article_order" :options="@js($articleOrderTypes)"
                                value="{{ old('article_order', $beforeAfterSetting->article_order ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="article_order"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>サブナビゲーション</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-select name="subnavigation" :options="@js($subnavigationTypes)" class="w-full"
                                option-label="label" option-value="key"
                                value="{{ old('subnavigation', $beforeAfterSetting->subnavigation ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="subnavigation"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>アクセス制限</th>
                    <td>
                        <div class="flex gap-5 flex-wrap">
                            <div class="flex flex-nowrap items-center">
                                <span class="flex-0 w-28">アカウント</span>
                                <input-text name="access_limitation_account" class="flex-1 w-44"
                                    value="{{ old('access_limitation_account', $beforeAfterSetting->access_limitation_account ?? '') }}"></input-text>
                            </div>
                            <div class="flex flex-nowrap items-center">
                                <span class="flex-0 w-28">パスワード</span>
                                <input-text name="access_limitation_password" class="flex-1 w-44"
                                    value="{{ old('access_limitation_password', $beforeAfterSetting->access_limitation_password ?? '') }}"></input-text>
                            </div>
                        </div>
                        <x-form-error for="access_limitation_account"></x-form-error>
                        <x-form-error for="access_limitation_password"></x-form-error>
                        <p class="mt-3">一覧・詳細ページにパスワードでロックすることが出来ます</p>
                    </td>
                </tr>
                <tr>
                    <th>独自&lt;head&gt;タグ内容</th>
                    <td>
                        <pv-textarea name="original_head_tag"
                            value="{{ old('original_head_tag', $beforeAfterSetting->original_head_tag ?? '') }}"
                            rows="3" class="w-full"></pv-textarea>
                        <x-form-error for="original_head_tag"></x-form-error>
                        <p class="mt-3">*設定内容によってはサイト表示が大幅に崩れる事があります。ご注意ください。</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2 class="text-xl font-bold mt-5 mb-2">テキスト設定</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th>上部タイトル</th>
                    <td>
                        <input-text name="above_title" class="w-full"
                            value="{{ old('above_title', $beforeAfterSetting->above_title ?? '') }}"></input-text>
                        <x-form-error for="above_title"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>上部サブタイトル</th>
                    <td>
                        <input-text name="above_subtitle" class="w-full"
                            value="{{ old('above_subtitle', $beforeAfterSetting->above_subtitle ?? '') }}"></input-text>
                        <x-form-error for="above_subtitle"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>上部テキスト</th>
                    <td>
                        <pv-textarea name="above_text"
                            value="{{ old('above_text', $beforeAfterSetting->above_text ?? '') }}" rows="3"
                            class="w-full"></pv-textarea>
                        <x-form-error for="above_text"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>上部タイトル・<br>サブタイトルの表示位置</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="above_titles_position" :options="@js($positionTypes)"
                                value="{{ old('above_titles_position', $beforeAfterSetting->above_titles_position ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="above_titles_position"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>上部テキストの表示位置</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="above_text_position" :options="@js($positionTypes)"
                                value="{{ old('above_text_position', $beforeAfterSetting->above_text_position ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="above_text_position"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>下部タイトル</th>
                    <td>
                        <input-text name="below_title" class="w-full"
                            value="{{ old('below_title', $beforeAfterSetting->below_title ?? '') }}"></input-text>
                        <x-form-error for="below_title"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>下部サブタイトル</th>
                    <td>
                        <input-text name="below_subtitle" class="w-full"
                            value="{{ old('below_subtitle', $beforeAfterSetting->below_subtitle ?? '') }}"></input-text>
                        <x-form-error for="below_subtitle"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>下部テキスト</th>
                    <td>
                        <pv-textarea name="below_text"
                            value="{{ old('below_text', $beforeAfterSetting->below_text ?? '') }}" rows="3"
                            class="w-full"></pv-textarea>
                        <x-form-error for="below_text"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>下部タイトル・<br>サブタイトルの表示位置</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="below_titles_position" :options="@js($positionTypes)"
                                value="{{ old('below_titles_position', $beforeAfterSetting->below_titles_position ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="below_titles_position"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>下部テキストの表示位置</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="below_text_position" :options="@js($positionTypes)"
                                value="{{ old('below_text_position', $beforeAfterSetting->below_text_position ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="below_text_position"></x-form-error>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener("load", (event) => {});
    </script>
@endpush
