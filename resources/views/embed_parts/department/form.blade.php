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
                    <th>部署・組織名<span class="text-red-500">※</span></th>
                    <td>
                        <input-text name="name" class="w-full" value="{{ old('name', $department->name ?? '') }}"
                            placeholder="見出しとして表示されます">
                        </input-text>
                        <x-form-error for="name"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>部署・組織　別名</th>
                    <td>
                        <input-text name="alias" class="w-full" value="{{ old('alias', $department->alias ?? '') }}">
                        </input-text>
                        <x-form-error for="alias"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>説明</th>
                    <td>
                        <pv-textarea name="description" class="w-full" value="{{ old('description', $department->description ?? '') }}"
                            rows="8">
                        </pv-textarea>
                        <x-form-error for="description"></x-form-error>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
