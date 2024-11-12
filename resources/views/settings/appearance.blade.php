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
    <form action="{{ route('setting.appearance.update') }}" method="post" enctype="multipart/form-data" class="h-full w-full pl-4 md:pl-0 pr-4">
        @csrf
        <h1 class="text-xl font-bold pb-4">ホームページ外観</h1>

        <div class="border">
            <div class="bg-zinc-200 p-4 flex gap-4">
                <p><span class="text-[#FF0000]">※</span>は入力必須項目です。</p>
            </div>

            <div class="p-4">
                <table class="table-auto w-full border-collapse">
                    <tbody>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                headerレイアウトパターン
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <pv-select size="small" name="header_layout" :options='@json($service->getHeaderLayoutOptions())'
                                    option-label="name" option-value="id" value="{{ old('header_layout', $site->header_layout ?? '') }}"
                                    class="w-full" placeholder="選択してください"></pv-select>
                                <p class="pt-4">pattern4選択時は独自CSSの編集が必要です</p>
                                <x-form-error for="header_layout"></x-form-error>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                headerがMVに重なるか
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <pv-select size="small" name="mv_overlay" :options='@json($service->getMvOverlayOptions())'
                                    option-label="name" option-value="id" value="{{ old('mv_overlay', $site->mv_overlay ?? '') }}"
                                    class="w-full" placeholder="選択してください"></pv-select>
                                <x-form-error for="mv_overlay"></x-form-error>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                headerスクロール追従
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <pv-select size="small" name="header_scroll" :options='@json($service->getHeaderScrollOptions())'
                                    option-label="name" option-value="id" value="{{ old('header_scroll', $site->header_scroll ?? '') }}"
                                    class="w-full" placeholder="選択してください"></pv-select>
                                <x-form-error for="header_scroll"></x-form-error>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                header幅
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <pv-select size="small" name="header_width" :options='@json($service->getHeaderWidthOptions())'
                                    option-label="name" option-value="id" value="{{ old('header_width', $site->header_width ?? '') }}"
                                    class="w-full" placeholder="選択してください"></pv-select>
                                <x-form-error for="header_width"></x-form-error>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                フォント種
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="flex gap-2 items-center">
                                    <p class="w-40">タイトルフォント</p>
                                    <pv-select size="small" name="title_font" :options='@json($service->getTitleFontOptions())'
                                        option-label="name" option-value="id" value="{{ old('title_font', $site->title_font ?? '') }}"
                                        class="w-80" placeholder="選択してください"></pv-select>
                                    <x-form-error for="title_font"></x-form-error>
                                </div>
                                <div class="flex gap-2 items-center pt-4">
                                    <p class="w-40">本文フォント</p>
                                    <pv-select size="small" name="body_font" :options='@json($service->getBodyFontOptions())'
                                        option-label="name" option-value="id" value="{{ old('body_font', $site->body_font ?? '') }}"
                                        class="w-80" placeholder="選択してください"></pv-select>
                                    <x-form-error for="body_font"></x-form-error>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                ローディングパターン
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <pv-select size="small" name="loading_animation" :options='@json($service->getLoadingAnimationOptions())'
                                    option-label="name" option-value="id" value="{{ old('loading_animation', $site->loading_animation ?? '') }}"
                                    class="w-full" placeholder="選択してください"></pv-select>
                                <x-form-error for="loading_animation"></x-form-error>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                ローディング画像
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="flex gap-8 items-center">
                                    <image-selector name="loading_animation_image" value="{{ $site->loading_animation_image ?? '' }}"></image-selector>
                                </div>
                                <x-form-error for="loading_animation_image"></x-form-error>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                ローディングの表示
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="flex gap-2">
                                    <pv-radio-button name="loading_animation_enabled" :options='@json($service->getLoadingAnimationEnabledOptions())'
                                        value="{{ old('loading_animation_enabled', $site->loading_animation_enabled ?? '') }}">
                                    </pv-radio-button>
                                </div>
                                <x-form-error for="loading_animation_enabled"></x-form-error>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                共通メイン画像
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="flex gap-8 items-center">
                                    <image-selector name="main_image" value="{{ $site->main_image ?? '' }}"></image-selector>
                                </div>
                                <x-form-error for="main_image"></x-form-error>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                画像の表示方法
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <pv-radio-button name="image_display_type" :options='@json($service->getImageDisplayTypeOptions())'
                                    value="{{ old('image_display_type', $site->image_display_type ?? '') }}">
                                </pv-radio-button>
                                <x-form-error for="image_display_type"></x-form-error>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                画像のポップアップ
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="flex gap-2">
                                    <pv-radio-button name="image_popup" :options='@json($service->getImagePopupOptions())'
                                        value="{{ old('image_popup', $site->image_popup ?? '') }}">
                                    </pv-radio-button>
                                </div>
                                <x-form-error for="image_popup"></x-form-error>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                デフォルトの表示位置
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="flex gap-2">
                                    <pv-radio-button name="element_alignment" :options='@json($service->getElementAlignmentOptions())'
                                        value="{{ old('element_alignment', $site->element_alignment ?? '') }}">
                                    </pv-radio-button>
                                </div>
                                <x-form-error for="element_alignment"></x-form-error>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                デフォルトの時差表示
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="flex gap-2">
                                    <pv-radio-button name="element_fadein" :options='@json($service->getElementFadeinOptions())'
                                        value="{{ old('element_fadein', $site->element_fadein ?? '') }}">
                                    </pv-radio-button>
                                </div>
                                <x-form-error for="element_fadein"></x-form-error>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                ノーイメージ画像のグレースケール
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="flex gap-2">
                                    <pv-radio-button name="noimage_grayscale" :options='@json($service->getNoimageGrayscaleOptions())'
                                        value="{{ old('noimage_grayscale', $site->noimage_grayscale ?? '') }}">
                                    </pv-radio-button>
                                </div>
                                <x-form-error for="noimage_grayscale"></x-form-error>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                footerレイアウトパターン
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <pv-select size="small" name="footer_layout" :options='@json($service->getFooterLayoutOptions())'
                                    option-label="name" option-value="id" value="{{ old('footer_layout', $site->footer_layout ?? '') }}"
                                    class="w-full" placeholder="選択してください"></pv-select>
                                <x-form-error for="footer_layout"></x-form-error>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                footer幅
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <pv-select size="small" name="footer_width" :options='@json($service->getFooterWidthOptions())'
                                    option-label="name" option-value="id" value="{{ old('footer_width', $site->footer_width ?? '') }}"
                                    class="w-full" placeholder="選択してください"></pv-select>
                                <x-form-error for="footer_width"></x-form-error>
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
