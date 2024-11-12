<x-manage.container>
    <x-flash></x-flash>
    <redirects-add
        :status='@json($statusOptions)'
        :path='{{json_encode(route('redirects.store'))}}'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
