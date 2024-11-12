<x-app>
    <manage-edit-layout>
        <template #header>
            <x-manage.header></x-manage.header>
        </template>

        <template #default>
            <div class="w-full h-full flex justify-center items-center flex-col">
                {{ $slot }}
            </div>
        </template>

        <template #footer>
            <x-manage.footer></x-manage.footer>
        </template>
    </manage-edit-layout>
</x-app>