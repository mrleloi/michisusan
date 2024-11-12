@props(['back-route'])

<div class="flex justify-center gap-5 sticky bottom-0 bg-white py-5">
    <a href="{{ route($backRoute) }}">
        <pv-button severity="danger" rounded size="small" class="w-40">一覧に戻る</pv-button>
    </a>
    <pv-button type="submit" severity="success" size="small" rounded class="w-40">登録</pv-button>
</div>
