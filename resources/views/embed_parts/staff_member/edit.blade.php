<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">編集</h1>
    <form action="{{ route('staff_member.update', $staffMember->id) }}" method="post">
        @method('PUT')
        @csrf
        @include('embed_parts.staff_member.form')

        <x-stick-regist-button back-route="staff_member.index"></x-stick-regist-button>
    </form>
</x-manage.container>
