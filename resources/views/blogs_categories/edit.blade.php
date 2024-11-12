<x-manage-edit-has-nav.container>
    <blogs-categories-edit
        :categories='@json($pages)'
        :data-update="{{ json_encode($blogsCategory) }}"
        :path='{{json_encode($path)}}'
        :back-path="{{ json_encode(route('blogs_categories.index')) }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage-edit-has-nav.container>
