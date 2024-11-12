<x-manage-edit-has-nav.container>
    <x-flash></x-flash>
    <blogs-setting-basic
        :path="{{ json_encode($path) }}"
        :back-path="{{ json_encode(route('blogs_posts.index')) }}"
        :subnavigations="{{ $subnavigations }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :successmessage="{{ json_encode(session('success')) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
        :validation-errors="{{ $errors }}"
        :data-update="{{ json_encode($blogsSetting) }}"
    />
</x-manage-edit-has-nav.container>
