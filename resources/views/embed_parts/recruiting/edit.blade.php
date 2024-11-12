<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">編集</h1>
    <form action="{{ route('recruiting.update', $recruiting->id) }}" method="post">
        @method('PUT')
        @csrf
        @include('embed_parts.recruiting.form')

        <x-stick-regist-button back-route="recruiting.index"></x-stick-regist-button>
    </form>
</x-manage.container>
