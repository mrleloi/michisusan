<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">新規追加</h1>
    <form action="{{ route('staff_member.store') }}" method="post">
        @csrf
        @include('embed_parts.staff_member.form')

        <x-stick-regist-button back-route="staff_member.index"></x-stick-regist-button>
    </form>
</x-manage.container>
