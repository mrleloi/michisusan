<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">新規追加</h1>
    <form action="{{ route('image_categories.store') }}" method="post">
        @csrf
        @include('image_categories.form')

        <x-stick-regist-button back-route="image_categories.index"></x-stick-regist-button>
    </form>
</x-manage.container>
