<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">編集</h1>
    <form action="{{ route('gallery_item.update', $galleryItem->id) }}" method="post">
        @method('PUT')
        @csrf
        @include('embed_parts.gallery_item.form')

        <x-stick-regist-button back-route="gallery_item.index"></x-stick-regist-button>
    </form>
</x-manage.container>
