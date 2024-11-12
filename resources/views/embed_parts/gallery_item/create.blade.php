<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">新規追加</h1>
    <form action="{{ route('gallery_item.store') }}" method="post">
        @csrf
        @include('embed_parts.gallery_item.form')

        <x-stick-regist-button back-route="gallery_item.index"></x-stick-regist-button>
    </form>
</x-manage.container>
