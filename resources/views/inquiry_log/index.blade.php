<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">お問い合わせ内容一覧</h1>
    <div class="border">
        <div class="bg-zinc-200 p-4">
            <form action="{{ route('inquiry_log.index', $inquiryFormId) }}">
                <div class="flex flex-wrap gap-y-2">
                    <div class="flex gap-3 items-center flex-wrap">
                        <pv-select size="small" name="per_page" :options='@json($perPageOptions)'
                            option-label='label' option-value='count' value="{{ $items->perPage() }}" class="w-32">
                        </pv-select>
                        <div class="flex flex-wrap items-center gap-x-2">
                            <label class="ml-3">期間</label>
                            <pv-date-picker name="received_at_from" date-format="yy/mm/dd" placeholder="yyyy/mm/dd"
                                value="{{ request()->query('received_at_from') }}" class="w-32"></pv-date-picker>
                            <p>〜</p>
                            <pv-date-picker name="received_at_to" date-format="yy/mm/dd" placeholder="yyyy/mm/dd"
                                value="{{ request()->query('received_at_to') }}" class="w-32"></pv-date-picker>
                        </div>
                        <pv-button size="small" label="表示更新" rounded type="submit"></pv-button>
                    </div>
                    <div class="flex-1 flex items-end whitespace-nowrap flex-col gap-y-3">
                        <pv-button size="small" label="CSVダウンロード (SJIS)" rounded class="w-48"
                            formaction="{{ route('inquiry_log.csv', ['inquiry_form_id' => $inquiryFormId, 'enc' => 'sjis']) }}"
                            type="submit"></pv-button>
                        <pv-button size="small" label="CSVダウンロード (UTF8)" rounded class="w-48"
                            formaction="{{ route('inquiry_log.csv', ['inquiry_form_id' => $inquiryFormId, 'enc' => 'utf8']) }}"
                            type="submit"></pv-button>
                    </div>
                </div>
                <x-form-error for="received_at_from"></x-form-error>
                <x-form-error for="received_at_from"></x-form-error>
            </form>
        </div>
        <div class="p-4">
            @if ($items->total())
                <form name="bulkdelete" action="{{ route('inquiry_log.bulk_delete') }}" method="POST"
                    onsubmit="return confirmSubmit()">
                    @csrf
                    @method('delete')
                    <pv-button size="small" label="チェックした項目を全て削除" rounded type="submit" class="mb-3"></pv-button>
                    <sortable-list :items='@json($items)' :columns='@json($columns)'
                        :actions='@json($listActions)' item-name='選択されたお問い合わせ内容'
                        :csrf-token='{{ json_encode(csrf_token()) }}'></sortable-list>
                </form>
            @else
                <div class="text-center">お問い合わせ内容が見つかりません。</div>
            @endif
        </div>
        <div class="text-center my-8">
            <a href="{{ route('inquiry_form.index') }}">
                <pv-button size="small" label="お問い合わせフォーム一覧に戻る" rounded></pv-button>
            </a>
        </div>
    </div>
    @if ($items->total())
        <paginator :items='@json($items)'> </paginator>
    @endif

    @push('scripts')
        <script>
            function confirmSubmit() {
                const checked = document.querySelectorAll('input[name="checks[]"]:checked')

                if (checked.length === 0) {
                    alert('削除対象を選択してください')
                    return false
                } else {
                    return confirm('選択したお問い合わせ内容を削除してよろしいですか？');
                }
            }
        </script>
    @endpush
</x-manage.container>
