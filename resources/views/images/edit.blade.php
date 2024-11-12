<x-manage.container>
    <x-flash></x-flash>
    <images-edit
        :image='@json($image)'
        :categories='@json($categoryList)'
        :options='@json($qualityOptions)'
        :path='{{json_encode($path)}}'
        :route='{{json_encode(route('images.index'))}}'
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
