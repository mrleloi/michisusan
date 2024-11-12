<x-manage.container>
    <x-flash></x-flash>
    <news-articles-setting
        :path="{{ json_encode($path) }}"
        :back-path="{{ json_encode(route('dashboard')) }}"
        :subnavigations="{{ $subnavigations }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :successmessage="{{ json_encode(session('success')) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
        :validation-errors="{{ $errors }}"
        :data-update="{{ json_encode($newsSetting) }}"
    />
</x-manage.container>
