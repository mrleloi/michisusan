<x-manage.container>
    <x-flash></x-flash>
    <images-add
        :categories='@json($categoryList)'
        :options='@json($qualityOptions)'
        :path='{{json_encode(route('images.store'))}}'
        :route='{{json_encode(route('images.index'))}}'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
