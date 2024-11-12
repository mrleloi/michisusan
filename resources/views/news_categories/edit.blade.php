<x-manage.container>
    <news-categories-edit
        :back-path="{{ json_encode(route('news_categories.index')) }}"
        :categories='@json($pages)'
        :data-update="{{ json_encode($newsCategory) }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
    />
</x-manage.container>
