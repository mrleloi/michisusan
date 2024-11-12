<x-manage.container>
    <news-categories-add
        :categories='@json($pages)'
        :path='{{json_encode(route('news_categories.store'))}}'
        :back-path="{{ json_encode(route('news_categories.index')) }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
