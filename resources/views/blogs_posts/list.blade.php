<x-manage.container>
    <x-flash></x-flash>
    @props(['items' => [], 'columns' => []])
    <div class="w-full h-full px-3">
        <h1 class="text-3xl mb-3">ブログ</h1>
        <div class="border">
            <div class="bg-[#EFF3F8] p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold">投稿一覧</h2>
                    <a href="{{ route('blogs_posts.create') }}">
                        <pv-button size="small" label="新規投稿" rounded></pv-button>
                    </a>
                </div>
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <blog-header-filter-list
                        :form-path='@json(route('blogs_posts.index'))'
                        :categories='@json($categories->all())'
                        :max-view-options='@json($maxViewOptions)'
                        :selected-public-status='@json(session('blogs_post_filters.blogs_post_public_status'))'
                        :csrf-token='@json(csrf_token())'
                        :filled-keyword='@json(session('blogs_post_filters.blogs_post_keyword', ''))'
                        :selected-option='@json(session('blogs_post_filters.blogs_post_max_view', 20))'
                        :selected-category='@json(session('blogs_post_filters.blogs_post_category_id'))'
                    >
                    </blog-header-filter-list>
                </div>
            </div>
            <div class="p-4">
                <form method="POST" action="{{ route('blogs_posts.bulkDelete') }}" id="bulk-delete-form">
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
        const bulkDeleteForm = document.querySelector('form[action="{{ route('blogs_posts.bulkDelete') }}"]');

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
