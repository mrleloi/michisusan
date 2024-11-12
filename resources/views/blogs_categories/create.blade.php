<x-manage-edit-has-nav.container>
    <blogs-categories-add
        :categories='@json($pages)'
        :path='{{json_encode(route('blogs_categories.store'))}}'
        :back-path='{{json_encode(route('blogs_categories.index'))}}'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage-edit-has-nav.container>
