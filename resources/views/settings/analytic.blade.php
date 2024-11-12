<x-manage.container>
    <x-flash></x-flash>
    <setting-analytic-edit
        :path="{{ json_encode(route('site_analytic_settings.update')) }}"
        :site="{{ json_encode($site) }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
