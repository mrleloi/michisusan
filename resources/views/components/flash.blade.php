@if (session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
    {{ session('success') }}
</div>
@endif
@if (session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
    {{ session('error') }}
</div>
@elseif (count($errors->all()))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
    {{ $validation_error_message ?? "処理を完了できませんでした。入力した内容を確認してください"}}
</div>
@endif