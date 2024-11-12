<x-manage.container>
    <x-flash></x-flash>
    <document-file-form
        :item="{{ json_encode($item) }}"
        :path='{{ json_encode(route('document_files.update', $item->id)) }}'
        :back-path='{{ json_encode(route('document_files.index')) }}'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errorMessages="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
