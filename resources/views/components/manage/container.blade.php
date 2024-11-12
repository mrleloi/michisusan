<x-app>
    <manage-layout>
        <template #header>
            <x-manage.header></x-manage.header>
        </template>

        <template #default>
            <div class="pt-4 w-full px-3">
                {{ $slot }}
            </div>
        </template>

        <template #footer>
            @if (in_array(Route::currentRouteName(), ['footer.index']))
                <x-manage.footer>
                    <div class="flex-1">
                        <p>ページ設定</p>
                    </div>
                </x-manage.footer>
            @else
                <x-manage.footer></x-manage.footer>
            @endif
        </template>
    </manage-layout>
</x-app>
