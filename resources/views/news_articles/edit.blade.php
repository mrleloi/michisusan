<x-manage-edit.container>
    <news-articles-parts-edit-form :data-update="{{ json_encode($newsArticle) }}"></news-articles-parts-edit-form>
    <news-articles-parts-setting-dialog :data-update="{{ json_encode($newsArticle) }}"></news-articles-parts-setting-dialog>
    <new-articles-setting-dialog
        :path="{{ json_encode($path) }}"
        :tags="{{ $tags }}"
        :subnavigations="{{ $subnavigations }}"
        :snses="{{ $snses }}"
        :categories="{{ $categories }}"
        :csrf-token="{{ json_encode(csrf_token()) }}"
        :successmessage="{{ json_encode(session('success')) }}"
        :errormessage="{{ json_encode($errors->toArray()) }}"
        :old-input="{{ json_encode(old()) }}"
        :validation-errors="{{ $errors }}"
        :data-update="{{ json_encode($newsArticle) }}"
    ></new-articles-setting-dialog>
</x-manage-edit.container>
