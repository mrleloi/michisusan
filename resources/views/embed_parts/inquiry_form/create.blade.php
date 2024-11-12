<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">新規追加</h1>
    <form action="{{ route('inquiry_form.store') }}" method="post">
        @csrf
        @include('embed_parts.inquiry_form.form')

        <x-stick-regist-button back-route="inquiry_form.index"></x-stick-regist-button>
    </form>
</x-manage.container>
