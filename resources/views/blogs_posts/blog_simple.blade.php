<x-manage.container>
    <blogs-simple-add
        :path="{{ json_encode($path) }}"
        :back-path="{{ json_encode(route('blogs_posts.index')) }}"
        :tags="{{ $tags }}"
        :subnavigations="{{ $subnavigations }}"
        :snses="{{ $snses }}"
        :categories="{{ $categories }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :successmessage="{{ json_encode(session('success')) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
        :validation-errors="{{ $errors }}"
    ></blogs-simple-add>
</x-manage.container>
