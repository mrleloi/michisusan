<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">編集</h1>
    <form action="{{ route('menu_category.update', $menuCategory->id) }}" method="post">
        @method('PUT')
        @csrf
        @include('embed_parts.menu_category.form')

        <x-stick-regist-button back-route="menu_category.index"></x-stick-regist-button>
    </form>
</x-manage.container>
