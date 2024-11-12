<x-manage.container>
    <x-flash></x-flash>
    <embed-script-edit
        :site="{{ json_encode($site) }}"
        :old-input="{{ json_encode(old()) }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :path='{{json_encode(route('settings.embedded_script.update'))}}'
        :back-path='{{json_encode(route('dashboard'))}}'
    >
    </embed-script-edit>
</x-manage.container>
