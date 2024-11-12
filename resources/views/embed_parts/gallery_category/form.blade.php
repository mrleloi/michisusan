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
                        <input-text name="name" class="w-full" value="{{ old('name', $galleryCategory->name ?? '') }}"
                            placeholder="見出しとして表示されます">
                        </input-text>
                        <x-form-error for="name"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>表示・非表示</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="visible" :options='@json($visibleOptions)'
                                value="{{ old('visible', $galleryCategory->visible ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="visible"></x-form-error>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
