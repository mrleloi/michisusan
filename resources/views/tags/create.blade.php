<x-manage.container>
    <tags-add
        :tags='@json($tags)'
        :path='{{json_encode(route('tags.store'))}}'
        :back-path='{{json_encode(route('tags.index'))}}'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
