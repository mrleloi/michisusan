<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">新規追加</h1>
    <form action="{{ route('faq_category.store') }}" method="post">
        @csrf
        @include('embed_parts.faq_category.form')

        <x-stick-regist-button back-route="faq_category.index"></x-stick-regist-button>
    </form>
</x-manage.container>
