<x-manage.container>
    <div class="w-full h-full px-3">
        <h1 class="text-3xl mb-3">新規追加</h1>
        <form action="{{ route('users.store') }}" method="post">
            @csrf
            @include('users.form')

            <div class="flex justify-center gap-5 sticky bottom-0 bg-white pt-5">
                <pv-button severity="danger" rounded size="small" class="w-40">一覧に戻る</pv-button>
                <pv-button type="submit" severity="success" size="small" rounded class="w-40">登録</pv-button>
            </div>
        </form>
    </div>
</x-manage.container>
