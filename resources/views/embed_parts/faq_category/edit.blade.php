<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">編集</h1>
    <form action="{{ route('faq_category.update', $faqCategory->id) }}" method="post">
        @method('PUT')
        @csrf
        @include('embed_parts.faq_category.form')

        <x-stick-regist-button back-route="faq_category.index"></x-stick-regist-button>
    </form>
</x-manage.container>
