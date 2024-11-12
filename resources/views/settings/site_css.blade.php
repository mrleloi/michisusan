<x-manage.container>
    <x-flash></x-flash>
    <setting-css-edit
        :items="{{ json_encode($items) }}"
        :last-item="{{ json_encode($lastItem) }}"
        :path='{{json_encode(route('site_css_settings.store'))}}'
        :back-path='{{json_encode(route('dashboard'))}}'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
