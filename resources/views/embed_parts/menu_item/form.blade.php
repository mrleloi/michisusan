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
        <table class="form-table">
            <tbody>
                <tr>
                    <th>カテゴリー名<span class="text-red-500">※</span></th>
                    <td>
                        <category-selector name="menu_category_id[]" :options='@json($menuCategories)' :multiple="true"
                            display="chip" option-label="name" option-value="id" :show-toggle-all="false"
                            :value='@json(old('menu_category_id', $selectedMenuCategories ?? []))'
                            class="w-full" dialog_component="MenuItemCategorySelector" placeholder="選択してください"></category-selector>
                        <x-form-error for="menu_category_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>メニュー名<span class="text-red-500">※</span></th>
                    <td> <input-text name="name" class="w-full"
                            value="{{ old('name', $menuItem->name ?? '') }}"></input-text>
                        <x-form-error for="name"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>金額<span class="text-red-500">※</span></th>
                    <td><pv-input-number name="price" placeholder="半角数値で入力すると自動的にカンマ区切りで表示されます"
                            value="{{ old('price', $menuItem->price ?? '') }}" class="w-full"></pv-input-number>
                        <x-form-error for="price"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>〜表示</th>
                    <td><pv-checkbox name="append_wave_dash"
                            :value="{{ old('append_wave_dash', $menuItem->append_wave_dash ?? 0) }}"></pv-checkbox><span
                            class="ml-5">金額の後ろに『〜』を表示する</span></td>
                </tr>
                <tr>
                    <th>消費税</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="tax_type" :options='@json($taxTypes)'
                                value="{{ old('tax_type', $menuItem->tax_type ?? '') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="tax_type"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>説明</th>
                    <td><pv-textarea name="description" value="{{ old('description', $menuItem->description ?? '') }}"
                            class="w-full h-48"></pv-textarea>
                        <x-form-error for="description"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>画像(1)</th>
                    <td><image-selector name="image1_id" value="{{ old('description', $menuItem->image1_id ?? '') }}"></image-selector>
                        <x-form-error for="image1_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>画像(2)</th>
                    <td><image-selector name="image2_id" value="{{ old('description', $menuItem->image2_id ?? '') }}"></image-selector>
                        <x-form-error for="image2_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>画像(3)</th>
                    <td><image-selector name="image3_id" value="{{ old('description', $menuItem->image3_id ?? '') }}"></image-selector>
                        <x-form-error for="image3_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>表示・非表示</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="visible" :options='@json($visibleOptions)'
                                value="{{ old('visible', $menuItem->visible ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="visible"></x-form-error>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
