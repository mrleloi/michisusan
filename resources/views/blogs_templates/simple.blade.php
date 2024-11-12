<x-manage.container>
    <blogs-simple-edit
        :path="{{ json_encode($path) }}"
        :back-path="{{ json_encode(route('blogs_templates.index')) }}"
        :tags="{{ $tags }}"
        :subnavigations="{{ $subnavigations }}"
        :snses="{{ $snses }}"
        :categories="{{ $categories }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :successmessage="{{ json_encode(session('success')) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
        :validation-errors="{{ $errors }}"
        :data-update="{{ json_encode($blogsTemplate) }}"
    ></blogs-simple-edit>
</x-manage.container>
