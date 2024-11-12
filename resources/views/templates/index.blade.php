<x-manage.container>
    @props(['items' => [], 'columns' => []])

    <div class="w-full h-full px-3">
        <h1 class="text-3xl mb-3">一覧</h1>
        <div class="border">
            <div class="bg-zinc-200 p-4">
                <form>
                    <div class="flex gap-3">
                        <dropdown :options="{{ Js::from($query['par_page_choices']) }}" name="per_page" :value="{{ $limit }}"></dropdown>
                        <pv-button size="small" label="表示更新" rounded type="submit"></pv-button>
                    </div>
                </form>
            </div>
            <div class="p-4">
                <form action="bulk_delete">
                    <pv-button size="small" label="チェックした項目を全て削除" rounded class="mb-2"></pv-button>
                    <sortable-list :actions="{{ Js::from($actions) }}" :items='@json($items)'
                        :columns='@json($columns)'></sortable-list>
                </form>
            </div>
        </div>
        <paginator :items='@json($items)'> </paginator>
    </div>
</x-manage.container>
