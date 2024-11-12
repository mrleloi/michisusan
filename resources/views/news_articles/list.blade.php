<x-manage.container>
    <x-flash></x-flash>
    @props(['items' => [], 'columns' => []])
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-3xl mb-3">新着情報</h1>
        <div class="border">
            <div class="bg-[#EFF3F8] p-4">
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <header-filter-list
                        :form-path='@json(route('news_articles.index'))'
                        :categories='@json($categories->all())'
                        :max-view-options='@json($maxViewOptions)'
                        :csrf-token='@json(csrf_token())'
                        :selected-option='@json(session('news_article_filters.news_article_max_view', 20))'
                        :selected-category='@json(session('news_article_filters.news_article_category_id'))'
                    >
                    </header-filter-list>
                    <a href="{{ route('news_articles.create') }}" class="mt-2 md:mt-0">
                        <pv-button size="small" label="新規追加" rounded></pv-button>
                    </a>
                </div>
            </div>
            <div class="p-4">
                <form method="POST" action="{{ route('news_articles.bulkDelete') }}" id="bulk-delete-form">
                    @csrf
                    <pv-button type="submit" size="small" label="チェックした項目を全て削除" rounded class="mb-2"></pv-button>
                    <news-article-sortable-list :items='@json($items)'
                                                :columns='@json($columns)'
                                                :csrf-token='@json(csrf_token())'></news-article-sortable-list>
                </form>
            </div>
        </div>
        <news-articles-list-paginator :items='@json($items->resource)'> </news-articles-list-paginator>
    </div>
</x-manage.container>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkDeleteForm = document.querySelector('form[action="{{ route('news_articles.bulkDelete') }}"]');

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
