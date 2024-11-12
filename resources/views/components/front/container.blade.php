<x-front.app>
    <x-front.header :site="$site" :headerFooterSetting="$headerFooterSetting" :menu="$menu" :page="$page"></x-front.header>

    <div class="pt-4 w-full px-3">
        {{ $slot }}
    </div>

    <x-front.footer :site="$site" :headerFooterSetting="$headerFooterSetting" :menu="$menu" :page="$page"></x-front.footer>
</x-front-app>
