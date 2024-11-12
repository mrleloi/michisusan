<x-manage.container>
    <x-flash></x-flash>
    <setting-payment-edit
        :item="{{json_encode($item)}}"
        :path='{{json_encode(route('site_payment_settings.update'))}}'
        :back-path='{{json_encode(route('dashboard'))}}'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
    />
</x-manage.container>
