<x-manage.container>
    <x-flash></x-flash>
    @props(['items' => [], 'columns' => []])
    <div class="w-full h-full px-3">
        <h1 class="text-3xl mb-3">一覧</h1>
        <div class="border">
            <div class="bg-[#EFF3F8] p-4">
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <blogs-categories-header-filter-list
                        :form-path='@json(route('blogs_categories.index'))'
                        :max-view-options='@json($maxViewOptions)'
                        :csrf-token='@json(csrf_token())'
                        :filled-keyword='@json(session('blogs_category_filters.blogs_category_keyword', ''))'
                        :selected-option='@json(session('blogs_category_filters.blogs_category_max_view', 10))'
                    >
                    </blogs-categories-header-filter-list>

                    <a href="{{ route('blogs_categories.create') }}" class="mt-2 md:mt-0">
                        <pv-button size="small" label="新規投稿" rounded></pv-button>
                    </a>
                </div>
            </div>
            <div class="p-4">
                <form method="POST" action="{{ route('blogs_categories.bulkDelete') }}" id="bulk-delete-form">
                    @csrf
                    <pv-button type="submit" size="small" label="チェックした項目を全て削除" rounded class="mb-2"></pv-button>
                    <blogs-categories-sortable-list :items='@json($items)'
                                                    :columns='@json($columns)'
                                                    :disable-sortable='@json($disableSortable)'
                                                    :csrf-token='@json(csrf_token())'>
                    </blogs-categories-sortable-list>
                </form>
            </div>
        </div>
        <news-articles-list-paginator :items='@json($items->resource)'> </news-articles-list-paginator>
    </div>
</x-manage.container>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkDeleteForm = document.querySelector('form[action="{{ route('blogs_categories.bulkDelete') }}"]');

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
