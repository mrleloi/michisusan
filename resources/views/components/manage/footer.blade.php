<div class="h-full flex justify-center whitespace-nowrap">
    @if ($slot->isEmpty())
        <div class="flex flex-1 justify-center items-center">
            <img src="{{ asset('img/kiwamilogo3.png') }}" alt="">
        </div>
    @else
        {{ $slot }}
    @endif
</div>