<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">新規追加</h1>
    <form action="{{ route('menu_item.store') }}" method="post">
        @csrf
        @include('embed_parts.menu_item.form')

        <x-stick-regist-button back-route="menu_item.index"></x-stick-regist-button>
    </form>
</x-manage.container>
