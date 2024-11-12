<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">編集</h1>
    <form action="{{ route('inquiry_form.update', $inquiryForm->id) }}" method="post">
        @method('PUT')
        @csrf
        @include('embed_parts.inquiry_form.form')

        <x-stick-regist-button back-route="inquiry_form.index"></x-stick-regist-button>
    </form>
</x-manage.container>
