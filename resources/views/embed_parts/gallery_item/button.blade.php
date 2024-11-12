<tr>
    <th>ボタン（{{ $no }}）</th>
    <td>
        <div class="flex gap-x-24">
            <pv-radio-button name="show_button{{ $no }}" :options="@js($buttonShowTypes)"
                value="{{ old('show_button' . $no, $galleryItem['show_button' . $no] ?? Arr::get($buttonShowTypes, '0.key', '')) }}"></pv-radio-button>
            <x-form-error for="show_button{{ $no }}"></x-form-error>
        </div>
        <div id="button{{ $no }}_detail" class="mt-5">
            <div class="flex gap-x-24">
                <pv-radio-button name="button{{ $no }}_link_type" :options="@js($buttonLinkTypes)"
                    value="{{ old('button' . $no . '_link_type', $galleryItem['button' . $no . '_link_type'] ?? Arr::get($buttonLinkTypes, '0.key', '')) }}"></pv-radio-button>
                <x-form-error for="button{{ $no }}_link_type"></x-form-error>
            </div>

            <div id="button{{ $no }}_select" class="mt-5">
                <pv-select size="small" name="button{{ $no }}_link_page_id" :options="@js([])"
                    option-label="name" option-value="id"
                    :value="{{ old('button' . $no . '_link_page_id', $galleryItem['button' . $no . '_link_page_id'] ?? '') }}"
                    class="w-full" placeholder="選択してください">
                </pv-select>
                <x-form-error for="button{{ $no }}_link_page_id"></x-form-error>
            </div>
            <div id="button{{ $no }}_text" class="mt-5">
                <input-text name="button{{ $no }}_link_page_url" class="w-full" placeholder="外部URL"
                    value="{{ old('button' . $no . '_link_page_url', $galleryItem['button' . $no . '_link_page_url'] ?? '') }}"></input-text>
                <x-form-error for="button{{ $no }}_link_page_url"></x-form-error>
            </div>

            <div class="mt-5">
                ボタンに表示する文言
            </div>
            <input-text name="button{{ $no }}_text" class="w-full"
                value="{{ old('button' . $no . '_text', $galleryItem['button' . $no . '_text'] ?? '') }}"></input-text>
            <x-form-error for="button{{ $no }}_text"></x-form-error>

            <div class="flex gap-x-24 mt-5">
                <pv-radio-button name="button{{ $no }}_link_open_type" :options="@js($buttonLinkOpenTypes)"
                    value="{{ old('button' . $no . '_link_open_type', $galleryItem['button' . $no . '_link_open_type'] ?? Arr::get($buttonLinkOpenTypes, '0.key', '')) }}"></pv-radio-button>
                <x-form-error for="button{{ $no }}_link_open_type"></x-form-error>
            </div>
        </div>
    </td>
</tr>
