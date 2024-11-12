<x-manage.container>
    <x-flash></x-flash>
    @props(['actions' => ['delete', 'edit', 'sortable', 'selectable']])
    <div class="w-full h-full px-3">
        <h1 class="text-3xl mb-3">画像ファイル一覧</h1>
        <div class="border">
            <div class="bg-zinc-200 p-4">
                <form action="{{ route('images.index') }}">
                    <div class="flex flex-wrap">
                        <div class="flex gap-3 items-center flex-wrap">
                            <pv-select size="small" name="image_file_category_id" :options='@json($categoryList)'
                                option-label='name' option-value='id' class="w-64" :value="{{$categoryId}}" placeholder="カテゴリー 一覧">
                            </pv-select>
                            <pv-button size="small" label="新規追加" rounded type="submit"></pv-button>
                        </div>
                        <div class="flex-1 justify-end flex items-center">
                            <a href="{{ route('images.create') }}">
                                <pv-button size="small" label="新規追加" rounded></pv-button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="p-4">
                @if ($items->total())
                    <form name="bulkdelete" action="{{ route('images.bulkDelete') }}" method="POST"
                        onsubmit="return confirmSubmit()">
                        @csrf
                        @method('delete')
                        <pv-button size="small" label="チェックした項目を全て削除" rounded type="submit"
                            class="mb-3"></pv-button>
                        <image-list :items='@json($items)'
                                       :actions='@json($actions)'
                                       :csrf-token='{{ json_encode(csrf_token()) }}'></image-list>
                    </form>
                @else
                    <div class="text-center">企業・店舗が見つかりません。</div>
                @endif
            </div>
        </div>
        @if ($items->total())
            <paginator :items='@json($items)'> </paginator>
        @endif
    </div>

    @push('scripts')
        <script>
            function confirmSubmit() {
                const checked = document.querySelectorAll('input[name="checks[]"]:checked')

                if (checked.length === 0) {
                    return false
                } else {
                    return confirm('選択した画像を削除してもよろしいですか?')
                }
            }
        </script>
    @endpush
</x-manage.container>
