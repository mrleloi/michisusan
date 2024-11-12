<x-manage.container>
    <x-flash></x-flash>
    <setting-sns-edit
        :item="{{ json_encode($item) }}"
        :path='{{ json_encode(route('site_sns_settings.update')) }}'
        :back-path='{{ json_encode(route('dashboard')) }}'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"/>
</x-manage.container>
