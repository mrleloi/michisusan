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
                        <input-text name="name" class="w-full" value="{{ old('name', $recruitingCategory->name ?? '') }}"
                            placeholder="見出しとして表示されます">
                        </input-text>
                        <x-form-error for="name"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>カテゴリー別名</th>
                    <td>
                        <input-text name="alias" class="w-full" value="{{ old('alias', $recruitingCategory->alias ?? '') }}"
                            placeholder="カテゴリの補助として表示されます">
                        </input-text>
                        <x-form-error for="alias"></x-form-error>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
