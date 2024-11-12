<x-manage.container>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 rounded relative mb-4" role="alert" style="top: 30px">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 rounded relative mb-4" role="alert" style="top: 30px">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('setting.initial.update') }}" method="post" enctype="multipart/form-data" class="h-full w-full pl-4 md:pl-0 pr-4">
        @csrf
        <h1 class="text-xl font-bold pb-4">初期設定</h1>

        <div class="border">
            <div class="bg-zinc-200 p-4 flex gap-4">
                <p><span class="text-[#FF0000]">※</span>は入力必須項目です。</p>
            </div>

            <div class="p-4">
                <table class="table-auto w-full border-collapse">
                    <tbody>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                業種
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <pv-select size="small" name="industry" :options='@json($industryOptions)'
                                    option-label="name" option-value="id" value="{{ old('industry', $site->industry ?? '') }}"
                                    show-clear
                                    class="w-44" placeholder="業種選択">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="pt-4">※変更するとページ一覧が初期化されます。元に戻すことはできませんのでご注意ください。</p>
            </div>
        </div>

        <div class="pt-4 flex gap-4 justify-center">
            <pv-button class="min-w-40" severity="danger" rounded>ダッシュボードに戻る</pv-button>
            <pv-button class="min-w-40" severity="success" rounded type="submit">登録</pv-button>
        </div>
    </form>
</x-manage.container>
