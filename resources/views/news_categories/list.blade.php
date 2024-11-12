<x-manage.container>
    <x-flash></x-flash>
    @props(['items' => [], 'columns' => []])
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-3xl mb-3">カテゴリー一覧</h1>
        <div class="border">
            <div class="bg-[#EFF3F8] p-4">
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <news-categories-header-filter-list
                        :form-path='@json(route('news_categories.index'))'
                        :max-view-options='@json($maxViewOptions)'
                        :csrf-token='@json(csrf_token())'
                        :filled-keyword='@json(session('news_category_filters.news_category_keyword', ''))'
                        :selected-option='@json(session('news_category_filters.news_category_max_view', 10))'
                    >
                    </news-categories-header-filter-list>

                    <a href="{{ route('news_categories.create') }}" class="mt-2 md:mt-0">
                        <pv-button size="small" label="新規追加" rounded></pv-button>
                    </a>
                </div>
            </div>
            <div class="p-4">
                <form method="POST" action="{{ route('news_categories.bulkDelete') }}" id="bulk-delete-form">
                    @csrf
                    <pv-button type="submit" size="small" label="チェックした項目を全て削除" rounded class="mb-2"></pv-button>
                    <news-categories-sortable-list :items='@json($items)'
                                                   :columns='@json($columns)'
                                                   :disable-sortable='@json($disableSortable)'
                                                   :csrf-token='@json(csrf_token())'></news-categories-sortable-list>
                </form>
            </div>
        </div>
        <news-articles-list-paginator :items='@json($items->resource)'> </news-articles-list-paginator>
    </div>
</x-manage.container>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkDeleteForm = document.querySelector('form[action="{{ route('news_categories.bulkDelete') }}"]');

        if (bulkDeleteForm) {
            bulkDeleteForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const checkedBoxes = this.querySelectorAll('input[name="checks[]"]:checked');

                if (checkedBoxes.length === 0) {
                    alert('削除する項目を選択してください。');
                    return;
                }

                if (confirm('選択した投稿を削除してよろしいですか？')) {
                    this.submit();
                }
            });
        }
    });
</script>
