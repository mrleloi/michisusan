@push('styles')
    @vite('resources/css/table.css')
@endpush
<div class="border">
    <div class="bg-zinc-200 p-4">
        <span class="text-red-500">※</span>は必須項目です
    </div>
    <div class="p-4">
        <h2 class="text-xl font-bold mb-2">募集元の企業情報</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th>企業名・屋号<span class="text-red-500">※</span></th>
                    <td> <input-text name="company_name" class="w-full"
                            value="{{ old('company_name', $recruiting->company_name ?? '') }}"></input-text>
                        <x-form-error for="company_name"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>URL</th>
                    <td> <input-text name="url" class="w-full"
                            value="{{ old('url', $recruiting->url ?? '') }}"></input-text>
                        <x-form-error for="url"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>郵便番号</th>
                    <td>
                        <div class="flex gap-x-3 items-center flex-wrap">
                            <span>〒</span>
                            <input-text name="zip1" class="w-20" :maxlength="3"
                                value="{{ old('zip1', $recruiting->zip1 ?? '') }}">
                            </input-text>
                            <span>−</span>
                            <input-text name="zip2" class="w-28" :maxlength="4"
                                value="{{ old('zip2', $recruiting->zip2 ?? '') }}">
                            </input-text>
                            <!--
                        <pv-button size="small" rounded class="w-40 p-postal-button"
                            id="address_auto_1">住所自動入力</pv-button>
                        -->
                        </div>

                        <x-form-error for="zip1"></x-form-error>
                        <x-form-error for="zip2"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>住所</th>
                    <td>
                        <div class="flex items-center flex-wrap">
                            <input-text name="prefecture" value="{{ old('prefecture', $recruiting->prefecture ?? '') }}"
                                class="w-40 mr-2 mb-2" placeholder="都道府県"></input-text>
                            <input-text name="city" value="{{ old('city', $recruiting->city ?? '') }}"
                                class="w-40 mr-2 mb-2" placeholder="市区町村">
                            </input-text>
                            <input-text name="town" value="{{ old('town', $recruiting->town ?? '') }}"
                                class="w-40 mr-2 mb-2" placeholder="町域">
                            </input-text>
                        </div>
                        <x-form-error for="prefecture"></x-form-error>
                        <x-form-error for="city"></x-form-error>
                        <x-form-error for="town"></x-form-error>
                        <input-text name="street_address"
                            value="{{ old('street_address', $recruiting->street_address ?? '') }}" class="w-full mb-2"
                            placeholder="町域や番地">
                        </input-text>
                        <x-form-error for="street_address"></x-form-error>
                        <input-text name="building" value="{{ old('building', $recruiting->building ?? '') }}"
                            class="w-full" placeholder="建物・ビル名"></input-text>
                        <x-form-error for="building"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>表示・非表示</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="visible" :options="@js($visibleOptions)"
                                value="{{ old('visible', $recruiting->visible ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="visible"></x-form-error>
                    </td>
                </tr>
            </tbody>
        </table>
        <h2 class="text-xl font-bold mt-5 mb-2">基本情報</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th>カテゴリー名<span class="text-red-500">※</span></th>
                    <td>
                        <category-selector name="recruiting_category_id" :options="@js($recruitingCategories)"
                            :multiple="false" option-label="name" option-value="id" :value="@js(intval(old('recruiting_category_id', $recruiting->recruiting_category_id ?? null), 10))"
                            class="w-full" dialog_component="RecruitingCategorySelector"
                            placeholder="選択してください"></category-selector>
                        <x-form-error for="recruiting_category_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>募集タイトル<span class="text-red-500">※</span></th>
                    <td> <input-text name="title" class="w-full"
                            value="{{ old('title', $recruiting->title ?? '') }}"></input-text>
                        <x-form-error for="title"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>募集職種<span class="text-red-500">※</span></th>
                    <td> <input-text name="occupation" class="w-full"
                            value="{{ old('occupation', $recruiting->occupation ?? '') }}"></input-text>
                        <x-form-error for="occupation"></x-form-error>
                        <p class="mt-3">複数の募集職種がある場合は『半角カンマ(,)』で区切ってください</p>
                    </td>
                </tr>
                <tr>
                    <th>仕事内容（概要）<span class="text-red-500">※</span></th>
                    <td>
                        <pv-textarea name="job_summary" class="w-full" rows="6"
                            value="{{ old('job_summary', $recruiting->job_summary ?? '') }}"></pv-textarea>
                        <x-form-error for="job_summary"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>仕事内容詳細<span class="text-red-500">※</span></th>
                    <td>
                        <pv-textarea name="job_detail" class="w-full" rows="6"
                            value="{{ old('job_detail', $recruiting->job_detail ?? '') }}"></pv-textarea>
                        <x-form-error for="job_detail"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>勤務地</th>
                    <td>
                        <div class="flex gap-x-3 items-center flex-wrap">
                            <span>〒</span>
                            <input-text name="wp_zip1" class="w-20" :maxlength="3"
                                value="{{ old('wp_zip1', $recruiting->wp_zip1 ?? '') }}">
                            </input-text>
                            <span>−</span>
                            <input-text name="wp_zip2" class="w-28" :maxlength="4"
                                value="{{ old('wp_zip2', $recruiting->wp_zip2 ?? '') }}">
                            </input-text>
                            <!--
                        <pv-button size="small" rounded class="w-40 p-postal-button"
                            id="address_auto_1">住所自動入力</pv-button>
                        -->
                        </div>
                        <x-form-error for="wp_zip1"></x-form-error>
                        <x-form-error for="wp_zip2"></x-form-error>
                        <div class="flex items-center flex-wrap">
                            <input-text name="wp_prefecture"
                                value="{{ old('wp_prefecture', $recruiting->wp_prefecture ?? '') }}"
                                class="w-40 mr-2 mt-2" placeholder="都道府県"></input-text>
                            <x-form-error for="wp_prefecture"></x-form-error>
                            <input-text name="wp_city" value="{{ old('wp_city', $recruiting->wp_city ?? '') }}"
                                class="w-40 mr-2 mt-2" placeholder="市区町村">
                            </input-text>
                            <x-form-error for="wp_city"></x-form-error>
                            <input-text name="wp_town" value="{{ old('wp_town', $recruiting->wp_town ?? '') }}"
                                class="w-40 mr-2 mt-2" placeholder="町域">
                            </input-text>
                        </div>
                        <x-form-error for="wp_town"></x-form-error>
                        <input-text name="wp_street_address"
                            value="{{ old('wp_street_address', $recruiting->wp_street_address ?? '') }}"
                            class="w-full mt-2" placeholder="町域や番地">
                        </input-text>
                        <x-form-error for="wp_street_address"></x-form-error>
                        <input-text name="wp_building"
                            value="{{ old('wp_building', $recruiting->wp_building ?? '') }}" class="w-full mt-2"
                            placeholder="建物・ビル名"></input-text>
                        <x-form-error for="wp_building"></x-form-error>
                        <p class="mt-3">※勤務地が未入力の場合、Google for Jobs や Indeed に掲載がされませんのでご注意ください</p>
                    </td>
                </tr>
                <tr>
                    <th>連絡先</th>
                    <td> <input-text name="contact_address" class="w-full"
                            value="{{ old('contact_address', $recruiting->contact_address ?? '') }}"
                            placeholder="電話番号やメールアドレスを入力してください"></input-text>
                        <x-form-error for="contact_address"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>担当者</th>
                    <td> <input-text name="pic" class="w-full"
                            value="{{ old('pic', $recruiting->pic ?? '') }}"></input-text>
                        <x-form-error for="pic"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>雇用形態<span class="text-red-500">※</span></th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-select name="employment_status" :options="@js($employmentStatusTypes)" class="w-full"
                                option-label="label" option-value="key"
                                value="{{ old('employment_status', $recruiting->employment_status ?? null) }}"
                                placeholder="選択してください"></pv-select>
                        </div>
                        <x-form-error for="employment_status"></x-form-error>
                    </td>
                </tr>

                <tr>
                    <th>給与</th>
                    <td>
                        <pv-select name="salary_type" :options="@js($salaryTypes)" class="w-full"
                            option-label="label" option-value="key"
                            value="{{ old('salary_type', $recruiting->salary_type ?? null) }}"
                            placeholder="選択してください"></pv-select>
                        <div class="flex flex-wrap gap-2 mt-5 items-center">
                            <div>最低&nbsp;<input-text name="salary_min" class="w-32"
                                    value="{{ old('salary_min', $recruiting->salary_min ?? '') }}"></input-text>&nbsp;円
                            </div>
                            <span>&nbsp;~&nbsp;</span>
                            <div>最高&nbsp;<input-text name="salary_max" class="w-32"
                                    value="{{ old('salary_max', $recruiting->salary_max ?? '') }}"></input-text>
                            </div>
                        </div>
                        <x-form-error for="salary_type"></x-form-error>
                        <x-form-error for="salary_min"></x-form-error>
                        <x-form-error for="salary_max"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>給与詳細</th>
                    <td>
                        <pv-textarea name="salary_detail" class="w-full" rows="6"
                            value="{{ old('salary_detail', $recruiting->salary_detail ?? '') }}"></pv-textarea>
                        <x-form-error for="salary_detail"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>画像(1)</th>
                    <td>
                        <image-selector name="image1_id"
                            value="{{ old('image1_id', $recruiting->image1_id ?? '') }}"></image-selector>
                        <x-form-error for="image1_id"></x-form-error>
                        <input-text name="image1_alt" class="w-full mt-2" placeholder="画像のaltを入力してください"
                            value="{{ old('image1_alt', $recruiting->image1_alt ?? '') }}"></input-text>
                    </td>
                </tr>
                <tr>
                    <th>画像(2)</th>
                    <td>
                        <image-selector name="image2_id"
                            value="{{ old('image2_id', $recruiting->image2_id ?? '') }}"></image-selector>
                        <x-form-error for="image2_id"></x-form-error>
                        <input-text name="image2_alt" class="w-full mt-2" placeholder="画像のaltを入力してください"
                            value="{{ old('image2_alt', $recruiting->image2_alt ?? '') }}"></input-text>
                    </td>
                </tr>
                <tr>
                    <th>画像(3)</th>
                    <td>
                        <image-selector name="image3_id"
                            value="{{ old('image3_id', $recruiting->image3_id ?? '') }}"></image-selector>
                        <x-form-error for="image3_id"></x-form-error>
                        <input-text name="image3_alt" class="w-full mt-2" placeholder="画像のaltを入力してください"
                            value="{{ old('image3_alt', $recruiting->image3_alt ?? '') }}"></input-text>
                    </td>
                </tr>
                <tr>
                    <th>MV上のテキスト</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="mv_text" :options="@js($mvTextTypes)"
                                value="{{ old('mv_text', $recruiting->mv_text ?? null) }}"></pv-radio-button>
                        </div>
                        <x-form-error for="mv_text"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>ボタン設定</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24 mt-5">
                            <pv-radio-button name="button_link_type" :options="@js($buttonLinkTypes)"
                                value="{{ old('button_link_type', $recruiting->button_link_type ?? null) }}"></pv-radio-button>
                            <x-form-error for="button_link_type"></x-form-error>
                        </div>
                        <div id="button_select" class="mt-5">
                            <pv-select name="button_link_page_id" :options="@js([])" class="w-full"
                                option-label="label" option-value="key"
                                value="{{ old('button_link_page_id', $recruiting->button_link_page_id ?? null) }}"
                                placeholder="選択してください"></pv-select>
                            <x-form-error for="button_link_page_id"></x-form-error>
                        </div>
                        <div id="button_url" class="mt-5">
                            <input-text name="button_link_page_url" class="w-full" placeholder=""
                                value="{{ old('button_link_page_url', $recruiting->button_link_page_url ?? '') }}"></input-text>
                            <x-form-error for="button_link_page_url"></x-form-error>
                        </div>
                        <div class="mt-5">
                            ボタンラベル
                        </div>

                        <input-text name="button_text" class="w-full"
                            value="{{ old('button_text', $recruiting->button_text ?? '') }}"></input-text>
                        <x-form-error for="button_text"></x-form-error>

                        <div class="flex flex-wrap gap-x-24 mt-5">
                            <pv-radio-button name="button_link_open_type" :options="@js($buttonLinkOpenTypes)"
                                value="{{ old('button_link_open_type', $recruiting->button_link_open_type ?? null) }}"></pv-radio-button>
                            <x-form-error for="button_link_open_type"></x-form-error>
                        </div>
                    </td>
                </tr>
                {{-- @for ($no = 1; $no <= 3; $no++)
                    @include('embed_parts.recruiting.button')
                @endfor --}}
            </tbody>
        </table>

        <h2 class="text-xl font-bold mt-5 mb-2">自由項目</h2>
        <recruiting-fields :fields="@js(old('rows', $recruitingFields ?? []))" :errors="@js($errors->toArray())">
        </recruiting-fields>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener("load", (event) => {
            document.querySelectorAll(
                    '[name="button_link_type"]')
                .forEach(e => {
                    //console.log("foreach", e, e.value)
                    e.addEventListener("change", () => {
                        switch_button_link_type(e)
                    })
                    switch_button_link_type(e)
                })
        });

        function switch_button_link_type(e) {
            const value = document.querySelector('Form')["button_link_type"].value
            if (value === "{{ $buttonLinkTypes[0]['key'] }}") {
                document.querySelector("#button_select").style.cssText = "";
                document.querySelector("#button_url").style.cssText = "display: none;";
            } else {
                document.querySelector("#button_select").style.cssText = "display: none;";
                document.querySelector("#button_url").style.cssText = "";
            }
        }
    </script>
@endpush
