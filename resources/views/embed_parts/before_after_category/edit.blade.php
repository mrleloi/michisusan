<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">編集</h1>
    <form action="{{ route('before_after_category.update', $beforeAfterCategory->id) }}" method="post">
        @method('PUT')
        @csrf
        @include('embed_parts.before_after_category.form')

        <x-stick-regist-button back-route="before_after_category.index"></x-stick-regist-button>
    </form>
</x-manage.container>
