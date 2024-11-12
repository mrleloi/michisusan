<x-manage.container>
    <x-flash></x-flash>
    <videos-add
        :categories='@json($categoryList)'
        :path='{{json_encode(route('videos.store'))}}'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
