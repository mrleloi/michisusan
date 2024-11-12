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
        <h2 class="text-3xl mb-4">基本情報</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th>部署・役職名<span class="text-red-500">※</span></th>
                    <td>
                        <pv-select size="small" name="department_id" :options="@js($departments)" option-label="name"
                            option-value="id" :value="{{ old('department_id', $staffMember->department_id ?? '') }}"
                            class="w-full" placeholder="選択してください">
                        </pv-select>
                        <x-form-error for="department_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>スタッフ名<span class="text-red-500">※</span></th>
                    <td>
                        <input-text name="name" class="w-full" value="{{ old('name', $staffMember->name ?? '') }}">
                        </input-text>
                        <x-form-error for="name"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>スタッフ別名</th>
                    <td>
                        <input-text name="another_name" class="w-full"
                            value="{{ old('another_name', $staffMember->another_name ?? '') }}">
                        </input-text>
                        <x-form-error for="another_name"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>画像</th>
                    <td>
                        <image-selector name="image_id"
                            value="{{ old('image_id', $staffMember->image_id ?? '') }}"></image-selector>
                        <x-form-error for="image_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>表示・非表示</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="visible" :options='@json($visibleOptions)'
                                value="{{ old('visible', $staffMember->visible ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="visible"></x-form-error>
                    </td>
                </tr>
            </tbody>
        </table>
        <h2 class="text-3xl mt-4 mb-2">自由項目</h2>
        <staff-member-fields :fields='@json(old('rows', $staffMemberAdditions ?? []))'
            :errors='@json($errors->toArray())'></staff-member-fields>
    </div>
</div>
