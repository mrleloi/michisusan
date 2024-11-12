@push('styles')
    @vite('resources/css/table.css')
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
                        <input-text name="name" class="w-full" value="{{ old('name', $menuCategory->name ?? '') }}"
                            placeholder="見出しとして表示されます">
                        </input-text>
                        <x-form-error for="name"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>カテゴリー別名</th>
                    <td>
                        <input-text name="alias" class="w-full" value="{{ old('alias', $menuCategory->alias ?? '') }}"
                            placeholder="カテゴリ名の補助として表示されます">
                        </input-text>
                        <x-form-error for="alias"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>説明</th>
                    <td>
                        <pv-textarea name="description" class="w-full" rows="8"
                            value="{{ old('description', $menuCategory->description ?? '') }}">
                        </pv-textarea>
                        <x-form-error for="description"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>画像(1)</th>
                    <td>
                        <image-selector name="image1_id"
                            value="{{ old('image1_id', $menuCategory->image1_id ?? '') }}"></image-selector>
                        <x-form-error for="image1_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>画像(2)</th>
                    <td>
                        <image-selector name="image2_id"
                            value="{{ old('image2_id', $menuCategory->image2_id ?? '') }}"></image-selector>
                        <x-form-error for="image2_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>画像(3)</th>
                    <td>
                        <image-selector name="image3_id"
                            value="{{ old('image3_id', $menuCategory->image3_id ?? '') }}"></image-selector>
                        <x-form-error for="image3_id"></x-form-error>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
