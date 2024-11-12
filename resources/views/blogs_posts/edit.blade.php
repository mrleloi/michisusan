<x-manage-edit.container>
    <blogs-posts-setting-dialog
        :path="{{ json_encode($path) }}"
        :tags="{{ $tags }}"
        :subnavigations="{{ $subnavigations }}"
        :snses="{{ $snses }}"
        :categories="{{ $categories }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :successmessage="{{ json_encode(session('success')) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
        :validation-errors="{{ $errors }}"
        :data-update="{{ json_encode($blogsPost) }}"
    ></blogs-posts-setting-dialog>
</x-manage-edit.container>
