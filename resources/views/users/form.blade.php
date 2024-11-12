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
                    <th>お名前<span class="text-red-500">※</span></th>
                    <td> <input-text name="name" class="w-full"
                            value="{{ old('name', $user->name ?? '') }}"></input-text>
                        <x-form-error for="name"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>メールアドレス<span class="text-red-500">※</span></th>
                    <td> <input-text name="email" class="w-full"
                            value="{{ old('email', $user->email ?? '') }}"></input-text>
                        <x-form-error for="email"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>パスワード<span class="text-red-500">※</span></th>
                    <td> <password name="password" class="w-full"
                            value="" :feedback="false"></password>
                        <x-form-error for="password"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>権限</th>
                    <td>
                        <div class="pt-5">
                            <pv-checkbox id="is_manager" name="is_manager"
                                :value="{{ old('is_manager', $user->is_manager ?? 0) }}"></pv-checkbox>
                            <label class="ml-5" for="is_manager"> マネージャーとして登録する</label>
                        </div>
                        <p class="pt-5">マネージャーは埋め込みパーツ・ブログ・新着情報のみが使用できます。<br>
                        反映には一度ログアウトしていただき、再度のログインが必要です。</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
