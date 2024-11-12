<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">新規追加</h1>
    <form action="{{ route('recruiting_setting.store') }}" method="post">
        @csrf
        @include('embed_parts.recruiting_setting.form', ['recruitingSetting' => []])

        <div class="flex justify-center gap-5 sticky bottom-0 bg-white py-5">
            <pv-button type="submit" severity="success" size="small" rounded class="w-40">登録</pv-button>
        </div>
    </form>
</x-manage.container>