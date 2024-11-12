<x-manage.container>
    <x-flash></x-flash>
    <site-map-edit
        :site="{{ json_encode($site) }}"
        :old-input="{{ json_encode(old()) }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :path='{{json_encode(route('settings.sitemap.update'))}}'
        :back-path='{{json_encode(route('dashboard'))}}'
        :errormessage="{{ json_encode($errors->toArray()) }}"
    >
    </site-map-edit>
</x-manage.container>
