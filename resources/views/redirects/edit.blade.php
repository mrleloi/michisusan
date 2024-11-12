<x-manage.container>
    <x-flash></x-flash>
    <redirects-edit
        :redirect='@json($redirect)'
        :status='@json($statusOptions)'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
