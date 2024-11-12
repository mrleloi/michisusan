<x-manage.container>
    <x-flash></x-flash>
    <settings-advanced
        :site="{{ json_encode($site) }}"
        :path='{{json_encode(route('settings.advanced.update'))}}'
        :back-path='{{json_encode(route('dashboard'))}}'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
