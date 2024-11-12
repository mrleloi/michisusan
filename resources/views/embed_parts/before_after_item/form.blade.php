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
                        <category-selector name="before_after_category_id" :options='@json($beforeAfterCategories)'
                            :multiple="false" option-label="name" option-value="id" :show-toggle-all="false"
                            :value='@js(intval(old('before_after_category_id', $galleryItem->gallery_category_id ?? null), 10))' class="w-full"
                            dialog_component="BeforeAfterCategorySelector"
                            placeholder="選択してください"></category-selector>
                        <x-form-error for="before_after_category_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>タイトル<span class="text-red-500">※</span></th>
                    <td> <input-text name="title" class="w-full"
                            value="{{ old('title', $beforeAfterItem->title ?? '') }}"></input-text>
                        <x-form-error for="title"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>内容</th>
                    <td><pv-textarea name="content" value="{{ old('content', $beforeAfterItem->content ?? '') }}"
                            class="w-full h-48"></pv-textarea>
                        <x-form-error for="content"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>ビフォー画像<span class="text-red-500">※</span></th>
                    <td><image-selector name="before_image_id" :can-delete="false"
                            value="{{ old('before_image_id', $beforeAfterItem->before_image_id ?? '') }}"></image-selector>
                        <x-form-error for="before_image_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>アフター画像<span class="text-red-500">※</span></th>
                    <td><image-selector name="after_image_id" :can-delete="false"
                            value="{{ old('after_image_id', $beforeAfterItem->after_image_id ?? '') }}"></image-selector>
                        <x-form-error for="after_image_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>表示・非表示</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="visible" :options='@json($visibleOptions)'
                                value="{{ old('visible', $beforeAfterItem->visible ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="visible"></x-form-error>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
