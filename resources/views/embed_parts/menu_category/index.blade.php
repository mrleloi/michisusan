<x-manage.container>
    <x-flash></x-flash>
    <div class="w-full h-full px-3">
        <h1 class="text-3xl mb-3">メニューカテゴリー一覧</h1>
        <div class="border">
            <div class="bg-zinc-200 p-4">
                <form action="{{ route('menu_category.index') }}">
                    <div class="flex flex-wrap">
                        <div class="flex gap-3 items-center flex-wrap">
                            <pv-select size="small" name="per_page" :options='@json($perPageOptions)'
                                option-label="label" option-value="count" value="{{ $items->perPage() }}"
                                class="w-32">
                            </pv-select>
                            <input-text size="small" name="keyword" value="{{ request()->query('keyword') }}"
                                class="w-64">
                            </input-text>
                            <pv-button size="small" label="表示更新" rounded type="submit"></pv-button>
                        </div>
                        <div class="flex-1 justify-end flex items-center">
                            <a href="{{ route('menu_category.create') }}">
                                <pv-button size="small" label="新規作成" rounded></pv-button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="p-4">
                @if ($items->total())
                    <form name="bulkdelete" action="{{ route('menu_category.bulk_delete') }}" method="POST"
                        onsubmit="return confirmSubmit()">
                        @csrf
                        @method('delete')
                        <pv-button size="small" label="チェックした項目を全て削除" rounded type="submit"
                            class="mb-3"></pv-button>
                        <sortable-list :items='@json($items)' :columns='@json($columns)'
                            :actions='@json($listActions)'
                            disable-delete='menu_item_count'
                            disable-check='menu_item_count'
                            :csrf-token='{{ json_encode(csrf_token()) }}'></sortable-list>
                    </form>
                @else
                    <div class="text-center">メニューが見つかりません。</div>
                @endif
            </div>
        </div>
        @if ($items->total())
            <paginator :items='@json($items)'> </paginator>
        @endif
    </div>

    @push('scripts')
        <script>
            function confirmSubmit() {
                const checked = document.querySelectorAll('input[name="checks[]"]:checked')

                if (checked.length === 0) {
                    alert('削除対象を選択してください')
                    return false
                } else {
                    return confirm('選択した企業・店舗を削除してよろしいですか？');
                }
            }
        </script>
    @endpush
</x-manage.container>
