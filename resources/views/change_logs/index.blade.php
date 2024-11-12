<x-manage.container>
    <x-flash></x-flash>
    <h1 class="text-3xl mb-3">更新履歴一覧</h1>
    <div class="border">
        <div class="bg-zinc-200 p-4">
            <form action="{{ route('change_logs.index') }}">
                <div class="flex flex-wrap">
                    <div class="flex gap-3 items-center flex-wrap">
                        <pv-select size="small" name="per_page" :options='@json($perPageOptions)'
                                   option-label='label' option-value='count' value="{{ $items->perPage() }}" class="min-w-[216px]">
                        </pv-select>
                        <pv-button size="small" label="表示更新" rounded type="submit"></pv-button>
                    </div>
                </div>
            </form>
        </div>
        <div class="p-4">
            @if ($items->total())
                <table class="table-auto w-full border-collapse">
                    <thead>
                    <tr>
                        <th class="p-2.5 bg-[#6366f1] border border-[#c4cbef] text-white">更新日時</th>
                        <th class="p-2.5 bg-[#6366f1] border border-[#c4cbef] text-white">種別</th>
                        <th class="p-2.5 bg-[#6366f1] border border-[#c4cbef] text-white">更新者名</th>
                        <th class="p-2.5 bg-[#6366f1] border border-[#c4cbef] text-white">ページタイトル</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($items->items() as $item)
                        <tr>
                            <td class="p-2.5 border border-[#c4cbef]">{{ $item['updated_at'] ?? '' }}</td>
                            <td class="p-2.5 border border-[#c4cbef]">{{ $item['status'] ?? '' }}</td>
                            <td class="p-2.5 border border-[#c4cbef]">{{ $item['user_name'] ?? '' }}</td>
                            <td class="p-2.5 border border-[#c4cbef]">{{ $item['page_title'] ?? '' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center">データがありません</div>
            @endif
        </div>
    </div>
    @if ($items->total())
        <paginator :items='@json($items)'> </paginator>
    @endif
</x-manage.container>
