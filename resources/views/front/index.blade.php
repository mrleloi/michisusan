@section('title', $page?->getTitle($site))

@push('meta')
    @include('components.front.meta', ['site' => $site, 'page' => $page])
@endpush

<x-front.container :site="$site" :headerFooterSetting="$headerFooterSetting" :menu="$menu" :page="$page">
    <div class="w-full whitespace-nowrap px-4">
        <!-- page コンテンツを出力 -->
        <div class="">
            <front :page='@json($page)'></front>
        </div>

    </div>
</x-front.container>
