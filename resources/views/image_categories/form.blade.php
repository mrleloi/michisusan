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
        <span class="text-red-500">※</span>は入力必須項目です。
    </div>
    <div class="p-4">
        <table class="form-table">
            <tbody>
            <tr>
                <th>カテゴリー名<span class="text-red-500">※</span></th>
                <td>
                    <input-text name="name" class="w-full" value="{{ old('name', $imageCategory->name ?? '') }}">
                    </input-text>
                    <x-form-error for="name"></x-form-error>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
