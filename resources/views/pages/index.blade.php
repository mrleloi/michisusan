<x-manage.container>
    <div class="h-full w-full pl-4 md:pl-0">
        <h1 class="text-xl font-bold">ホームページ構成</h1>

        <div class="flex justify-between pt-4 pr-4">
            <page-batch-buttons></page-batch-buttons>

            <ul class="flex gap-4">
                <li>
                    <pv-button rounded onclick="location.href='{{ route('pages.templates') }}'">ページを追加</pv-button>
                </li>
            </ul>
        </div>

        <page-list :pages='@json($pages)'></page-list>

        <hr class="my-8">

        <h1 class="text-xl font-bold py-4">外部リンクメニュー</h1>

        <div class="pt-4 pr-4">
            <external-link-form></external-link-form>
        </div>
    </div>
</x-manage.container>
