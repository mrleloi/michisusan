<x-manage.container>
    <tags-edit
        :back-path='{{json_encode(route('tags.index'))}}'
        :tags='@json($tags)'
        :data-update="{{ json_encode($tag) }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
