<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">編集</h1>
    <form action="{{ route('recruiting_category.update', $recruitingCategory->id) }}" method="post">
        @method('PUT')
        @csrf
        @include('embed_parts.recruiting_category.form')

        <x-stick-regist-button back-route="recruiting_category.index"></x-stick-regist-button>
    </form>
    </div>
</x-manage.container>
