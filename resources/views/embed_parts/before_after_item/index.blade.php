<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">ビフォーアフター一覧</h1>
    <div class="border">
        <div class="bg-zinc-200 p-4">
            <form action="{{ route('before_after_item.index') }}">
                <div class="flex flex-wrap gap-y-2">
                    <div class="flex gap-3 items-center flex-wrap">
                        <pv-select size="small" name="category_id" :options='@json($categoryOptions)'
                            option-label="name" option-value="id" :value="{{ request()->query('category_id') ?? null }}"
                            class="w-56" placeholder="ビフォーアフター一覧" show-clear>
                        </pv-select>
                        <pv-select size="small" name="per_page" :options='@json($perPageOptions)'
                            option-label="label" option-value="count" value="{{ $items->perPage() }}" class="w-48">
                        </pv-select>
                        <pv-select size="small" name="visible" :options='@json($visibleOptions)'
                            option-label="label" option-value="key"
                            :value="@js(request()->query('visible') ?? null)"
                            class="w-44" placeholder="表示・非表示" show-clear>
                        </pv-select>
                        <input-text size="small" name="keyword" value="{{ request()->query('keyword') }}"
                            class="w-64">
                        </input-text>
                        <pv-button size="small" label="表示更新" rounded type="submit"></pv-button>
                    </div>
                    <div class="flex-1 justify-end flex items-center whitespace-nowrap">
                        <a href="{{ route('before_after_item.create') }}">
                            <pv-button size="small" label="新規作成" rounded></pv-button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="p-4">
            @if ($items->total())
                <form name="bulkdelete" action="{{ route('before_after_item.bulk_delete') }}" method="POST"
                    onsubmit="return confirmSubmit()">
                    @csrf
                    @method('delete')
                    <pv-button size="small" label="チェックした項目を全て削除" rounded type="submit" class="mb-3"></pv-button>
                    <sortable-list :items='@json($items)' :columns='@json($columns)'
                        :actions='@json($listActions)'
                        :csrf-token='{{ json_encode(csrf_token()) }}'></sortable-list>
                </form>
            @else
                <div class="text-center">ビフォーアフターが見つかりません。</div>
            @endif
        </div>
    </div>
    @if ($items->total())
        <paginator :items='@json($items)'> </paginator>
    @endif

    @push('scripts')
        <script>
            function confirmSubmit() {
                const checked = document.querySelectorAll('input[name="checks[]"]:checked')

                if (checked.length === 0) {
                    alert('削除対象を選択してください')
                    return false
                } else {
                    return confirm('選択したビフォーアフターを削除してよろしいですか？');
                }
            }
        </script>
    @endpush
</x-manage.container>