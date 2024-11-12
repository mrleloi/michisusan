<x-manage.container>
    @props(['actions' => ['delete', 'edit', 'selectable']])

    <div class="w-full h-full px-3">
        <h1 class="text-3xl mb-3">ユーザー一覧</h1>
        <div class="border">
            <div class="bg-zinc-200 p-4">
                <form action="{{ route('users.index') }}">
                    <div class="flex gap-3">
                        <pv-select size="small" name="per_page" :options='@json($perPageOptions)'
                            option-label='label' option-value='count' value="{{ $items->perPage() }}" class="w-48">
                        </pv-select>
                        <pv-button size="small" label="表示更新" rounded type="submit"></pv-button>
                        <pv-button size="small" label="新規追加" rounded class="ml-auto" onclick="location.href='{{ route('users.create') }}'"></pv-button>
                    </div>
                </form>
            </div>
            <div class="p-4">
                <form name="bulk_delete" action="{{ route('users.bulk_delete') }}" method="POST"
                    onsubmit="return confirmSubmit()">
                    @csrf
                    @method('delete')
                    <pv-button size="small" label="チェックした項目を全て削除" rounded type="submit"
                        class="mb-3"></pv-button>
                    <sortable-list :items='@json($items)' :columns='@json($columns)'
                        :actions='@json($actions)'
                        :csrf-token='{{ json_encode(csrf_token()) }}'></sortable-list>
                </form>
        </div>
        <paginator :items='@json($items)'> </paginator>
    </div>

    @push('scripts')
        <script>
            function confirmSubmit() {
                const checked = document.querySelectorAll('input[name="checks[]"]:checked')

                if (checked.length === 0) {
                    alert('削除対象を選択してください')
                    return false
                } else {
                    return confirm('選択したユーザーを削除してよろしいですか？');
                }
            }
        </script>
    @endpush
</x-manage.container>
