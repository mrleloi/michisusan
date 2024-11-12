<x-manage.container>
    <x-flash></x-flash>
    @props(['items' => [], 'columns' => []])
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-3xl mb-3">タグ 一覧</h1>
        <div class="border">
            <div class="bg-[#EFF3F8] p-4">
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <tags-header-filter-list
                        :form-path='@json(route('tags.index'))'
                        :max-view-options='@json($maxViewOptions)'
                        :csrf-token='@json(csrf_token())'
                        :filled-keyword='@json(session('tag_filters.tag_keyword', ''))'
                        :selected-option='@json(session('tag_filters.tag_max_view', 10))'
                    >
                    </tags-header-filter-list>

                    <a href="{{ route('tags.store') }}" class="mt-2 md:mt-0">
                        <pv-button size="small" label="新規追加" rounded></pv-button>
                    </a>
                </div>
            </div>
            <div class="p-4">
                <form method="POST" action="{{ route('tags.bulkDelete') }}" id="bulk-delete-form">
                    @csrf
                    <pv-button type="submit" size="small" label="チェックした項目を全て削除" rounded class="mb-2"></pv-button>
                    <tags-sortable-list :items='@json($items)'
                                                   :columns='@json($columns)'
                                                   :disable-sortable='@json($disableSortable)'
                                                   :csrf-token='@json(csrf_token())'></tags-sortable-list>
                </form>
            </div>
        </div>
        @if ($items->total())
            <paginator :items='@json($items->resource)'> </paginator>
        @endif
    </div>
</x-manage.container>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkDeleteForm = document.querySelector('form[action="{{ route('tags.bulkDelete') }}"]');

        if (bulkDeleteForm) {
            bulkDeleteForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const checkedBoxes = this.querySelectorAll('input[name="checks[]"]:checked');

                if (checkedBoxes.length === 0) {
                    alert('削除する項目を選択してください。');
                    return;
                }

                if (confirm('選択したタグを削除してよろしいですか？')) {
                    this.submit();
                }
            });
        }
    });
</script>
