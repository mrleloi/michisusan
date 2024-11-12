<x-manage.container>
    <form action="{{ route('sidenavi.post') }}" method="post" class="h-full w-full pl-4 md:pl-0 pr-4">
        @csrf
        <h1 class="text-xl font-bold pb-4">サイドバナー</h1>

        <div class="border">
            <div class="bg-zinc-200 p-4 flex gap-4">
                <p><span class="text-[#FF0000]">※</span>は入力必須項目です。</p>
            </div>

            <div class="p-4">
                <table class="table-auto w-full text-center border-collapse">
                    <tbody>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                上部バナー(1)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="top_banner1"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                上部バナー(2)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="top_banner2"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                上部バナー(3)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="top_banner3"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                上部バナー(4)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="top_banner4"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                上部バナー(5)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="top_banner5"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                上部バナー(6)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="top_banner6"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                上部バナー(7)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="top_banner7"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                上部バナー(8)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="top_banner8"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                下部バナー(1)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="bottom_banner1"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                下部バナー(2)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="bottom_banner2"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                下部バナー(3)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="bottom_banner3"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                下部バナー(4)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="bottom_banner4"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                下部バナー(5)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="bottom_banner5"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                下部バナー(6)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="bottom_banner6"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                下部バナー(7)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="bottom_banner7"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold">
                                下部バナー(8)
                            </td>
                            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
                                <navibar-setting class="flex gap-4" input-id="bottom_banner8"
                                    :banner='@json($banner)'
                                    :pages='@json($pages)'></navibar-setting>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pt-4 flex gap-4 justify-center">
            <pv-button class="min-w-40" severity="danger" rounded>ダッシュボードに戻る</pv-button>
            <pv-button class="min-w-40" severity="success" rounded type="submit">登録</pv-button>
        </div>
    </form>
</x-manage.container>
