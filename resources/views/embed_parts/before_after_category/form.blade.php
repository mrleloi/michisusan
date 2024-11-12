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
                    <td> <input-text name="name" class="w-full"
                            value="{{ old('name', $beforeAfterCategory->name ?? '') }}"></input-text>
                        <x-form-error for="name"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>カテゴリー別名</th>
                    <td> <input-text name="alias" class="w-full"
                            value="{{ old('alias', $beforeAfterCategory->alias ?? '') }}"></input-text>
                        <x-form-error for="alias"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>説明</th>
                    <td><ck-editor name="description"
                            value="{{ old('description', $beforeAfterCategory->description ?? '') }}"
                            class="w-full"></ck-editor>
                        <x-form-error for="description"></x-form-error>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
