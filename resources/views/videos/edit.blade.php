<x-manage.container>
    <x-flash></x-flash>
    <videos-edit
        :video='@json($video)'
        :categories='@json($categoryList)'
        :path='{{json_encode($path)}}'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
