@push('styles')
    @vite('resources/css/table.css')
    <style>
        .p-multiselect .p-multiselect-label {
            white-space: normal;
            display: inline-block;
        }

        .p-multiselect .p-multiselect-label-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .p-multiselect .p-multiselect-chip {
            margin: 2px;
        }
    </style>
@endpush
<div class="border">
    <div class="bg-zinc-200 p-4">
        <span class="text-red-500">※</span>は必須項目です
    </div>
    <div class="p-4">
        <h2 class="text-3xl mb-4">基本情報</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th>企業・店舗名<span class="text-red-500">※</span></th>
                    <td>
                        <input-text name="name" class="w-full" value="{{ old('name', $shopItem->name ?? '') }}">
                        </input-text>
                        <x-form-error for="name"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>郵便番号</th>
                    <td>
                        〒
                        <input-text name="zip1" class="w-32" value="{{ old('zip1', $shopItem->zip1 ?? '') }}">
                        </input-text>
                        −
                        <input-text name="zip2" class="w-40" value="{{ old('zip2', $shopItem->zip2 ?? '') }}">
                        </input-text>
                        <x-form-error for="zip1"></x-form-error>
                        <x-form-error for="zip2"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>住所</th>
                    <td>
                        <div class="flex flex-wrap gap-x-10">
                            <pv-radio-button name="address_type" :options="{{ Js::from($addressTypes) }}"
                                value="{{ old('address_type', $shopItem->address_type ?? Arr::get($addressTypes, '0.key', '')) }}"></pv-radio-button>
                        </div>
                        <x-form-error for="address_type"></x-form-error>
                        <div id="address_simple" class="mt-3">
                            <input-text name="address1" value="{{ old('address1', $shopItem->address1 ?? '') }}"
                                class="w-full"></input-text>
                            <x-form-error for="address1"></x-form-error>
                            <input-text name="address2" value="{{ old('address2', $shopItem->address2 ?? '') }}"
                                class="w-full mt-2"></input-text>
                            <x-form-error for="address2"></x-form-error>
                        </div>

                        <div id="address_detail" class="mt-5">
                            <input-text name="prefecture" value="{{ old('prefecture', $shopItem->prefecture ?? '') }}"
                                class="w-full"></input-text>
                            <x-form-error for="prefecture"></x-form-error>
                            <input-text name="city" value="{{ old('city', $shopItem->city ?? '') }}"
                                class="w-full mt-2">
                            </input-text>
                            <x-form-error for="city"></x-form-error>
                            <input-text name="town" value="{{ old('town', $shopItem->town ?? '') }}"
                                class="w-full mt-2">
                            </input-text>
                            <x-form-error for="town"></x-form-error>
                            <input-text name="building" value="{{ old('building', $shopItem->building ?? '') }}"
                                class="w-full mt-2"></input-text>
                            <x-form-error for="building"></x-form-error>
                        </div>

                        <div class="flex flex-wrap gap-x-10 mt-5">
                            <pv-radio-button name="map_type" :options="{{ Js::from($mapTypes) }}"
                                value="{{ old('map_type', $shopItem->map_type ?? Arr::get($mapTypes, '0.key', '')) }}"></pv-radio-button>
                            <x-form-error for="map_type"></x-form-error>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td>
                        <input-text name="tel_no" class="w-full" value="{{ old('tel_no', $shopItem->tel_no ?? '') }}">
                        </input-text>
                        <x-form-error for="tel_no"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>FAX番号</th>
                    <td>
                        <input-text name="fax_no" class="w-full" value="{{ old('fax_no', $shopItem->fax_no ?? '') }}">
                        </input-text>
                        <x-form-error for="fax_no"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>画像</th>
                    <td>
                        <image-selector name="image_id"
                            value="{{ old('image_id', $shopItem->image_id ?? '') }}"></image-selector>
                        <x-form-error for="image_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>署名パーツ用ロゴ</th>
                    <td>
                        <image-selector name="sign_logo_image_id"
                            value="{{ old('sign_logo_image_id', $shopItem->sign_logo_image_id ?? '') }}"></image-selector>
                        <x-form-error for="sign_logo_image_id"></x-form-error>
                        <p class="mt-3">一部のパーツに表示されます</p>
                    </td>
                </tr>
                <tr>
                    <th>署名パーツ用説明</th>
                    <td>
                        <pv-textarea name="description" value="{{ old('description', $shopItem->description ?? '') }}"
                            rows="3" class="w-full"></pv-textarea>
                        <x-form-error for="description"></x-form-error>
                        <p class="mt-3">一部のパーツに表示されます</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <h2 class="text-3xl mt-4 mb-2">自由項目</h2>
        <shop-item-fields :fields='@json(old('rows', $shopItemAdditions ?? []))'
            :errors='@json($errors->toArray())'></shop-item-fields>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener("load", (event) => {
            document.getElementsByName("address_type").forEach(e => {
                e.addEventListener("change", () => {
                    switch_address(document.querySelector('Form').address_type.value)
                })
            })
            switch_address(document.querySelector('Form').address_type.value);
        });

        function switch_address(value) {
            if (value === "{{ $mapTypes[0]['key'] }}") {
                document.querySelector('#address_simple').style.cssText = "";
                document.querySelector('#address_detail').style.cssText = "display: none;";
            } else {
                document.querySelector('#address_simple').style.cssText = "display: none;";
                document.querySelector('#address_detail').style.cssText = "";
            }
        }
    </script>
@endpush
