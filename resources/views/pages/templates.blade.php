<x-manage.container>
    <div class="h-full w-full pl-4 md:pl-0 pr-4">
        <h1 class="text-xl font-bold pb-4">新規追加</h1>

        <div class="border">
            <div class="bg-zinc-200 p-4 flex gap-4">
                <form class="flex-1">
                    @csrf
                    <div class="flex gap-3">
                        <dropdown :options="{{ Js::from($query['per_page']) }}" name="per_page" :value="{{ $limit }}"></dropdown>
                        <pv-button size="small" label="表示更新" rounded type="submit"></pv-button>
                    </div>
                </form>

                <form class="flex-1 flex justify-end" action="{{ route('pages.create') }}" method="get">
                    <pv-button size="small" rounded type="submit">テンプレートを使用せず制作</pv-button>
                </form>
            </div>

            <div class="p-4">
                <table class="table-auto w-full text-center border-collapse">
                    <thead>
                        <th class="w-9/12 p-[10px] bg-[#6366f1] text-white border border-solid border-[#c4cbef]">テンプレート名
                        </th>
                        <th class="p-[10px] bg-[#6366f1] text-white border border-solid border-[#c4cbef]">テンプレートを使用</th>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class="p-[0.2rem] border border-solid border-[#c4cbef]">
                                    {{ $item->id }}
                                </td>
                                <td class="p-[0.2rem] border border-solid border-[#c4cbef]">
                                    <form action="{{ route('pages.create') }}" method="get">
                                        <input type="hidden" name="template_id" value="{{ $item->id }}">
                                        <pv-button rounded type="submit">テンプレートを使用</pv-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <paginator :items='@json($items)'> </paginator>
    </div>
    </div>
</x-manage.container>
