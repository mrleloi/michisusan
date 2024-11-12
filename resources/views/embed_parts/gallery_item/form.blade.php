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
                        <category-selector name="gallery_category_id" :options='@json($galleryCategories)'
                            :multiple="false" option-label="name" option-value="id" :value="@js(intval(old('gallery_category_id', $galleryItem->gallery_category_id ?? null), 10))"
                            class="w-full" dialog_component="GalleryItemCategorySelector"
                            placeholder="選択してください"></category-selector>
                        <x-form-error for="gallery_category_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>タイトル<span class="text-red-500">※</span></th>
                    <td> <input-text name="title" class="w-full"
                            value="{{ old('title', $galleryItem->title ?? '') }}"></input-text>
                        <x-form-error for="title"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>サブタイトル</th>
                    <td> <input-text name="subtitle" class="w-full"
                            value="{{ old('subtitle', $galleryItem->subtitle ?? '') }}"></input-text>
                        <x-form-error for="subtitle"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>説明（抜粋）</th>
                    <td>
                        <ck-editor name="summary" class="w-full"
                            value="{{ old('summary', $galleryItem->summary ?? '') }}"></ck-editor>
                        <x-form-error for="summary"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>説明（詳細）</th>
                    <td> <ck-editor name="description" class="w-full"
                            value="{{ old('description', $galleryItem->description ?? '') }}"></ck-editor>
                        <x-form-error for="description"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>アイキャッチ画像</th>
                    <td>
                        <image-selector name="image_id"
                            value="{{ old('image_id', $galleryItem->image_id ?? '') }}"></image-selector>
                        <x-form-error for="image_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>外部リンク</th>
                    <td> <input-text name="link_url" class="w-full" placeholder="外部URL"
                            value="{{ old('link_url', $galleryItem->link_url ?? '') }}"></input-text>
                        <x-form-error for="link_url"></x-form-error>
                    </td>
                </tr>
                @for ($no = 1; $no <= 3; $no++)
                    @include('embed_parts.gallery_item.button')
                @endfor
                <tr>
                    <th>表示・非表示</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="visible" :options='@json($visibleOptions)'
                                value="{{ old('visible', $galleryItem->visible ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="visible"></x-form-error>
                    </td>
                </tr>
            </tbody>
        </table>

        画像
        <gallery-item-images :fields="@js(old('rows', $galleryItemImages ?? []))" :errors="@js($errors->toArray())">
        </gallery-item-images>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener("load", (event) => {
            document.querySelectorAll('[name="show_button1"], [name="show_button2"], [name="show_button3"]')
                .forEach(e => {
                    //console.log("foreach", e, e.value)
                    e.addEventListener("change", () => {
                        switch_show_button(e)
                    })
                    switch_show_button(e)
                })
            document.querySelectorAll(
                    '[name="button1_link_type"], [name="button2_link_type"], [name="button3_link_type"]')
                .forEach(e => {
                    //console.log("foreach", e, e.value)
                    e.addEventListener("change", () => {
                        switch_button_link_type(e)
                    })
                    switch_button_link_type(e)
                })
        });

        function switch_show_button(e) {
            const target_id = e.name.substring(5)
            const value = document.querySelector('Form')["show_" + target_id].value
            if (value === "{{ $buttonShowTypes[0]['key'] }}") {
                document.querySelector("#" + target_id + "_detail").style.cssText = "display: none;";
            } else {
                document.querySelector("#" + target_id + "_detail").style.cssText = "";
            }
        }

        function switch_button_link_type(e) {
            const target_id = e.name.substring(0, 7)
            const value = document.querySelector('Form')[target_id + "_link_type"].value
            if (value === "{{ $buttonLinkTypes[0]['key'] }}") {
                document.querySelector("#" + target_id + "_select").style.cssText = "";
                document.querySelector("#" + target_id + "_text").style.cssText = "display: none;";
            } else {
                document.querySelector("#" + target_id + "_select").style.cssText = "display: none;";
                document.querySelector("#" + target_id + "_text").style.cssText = "";
            }
        }
    </script>
@endpush
