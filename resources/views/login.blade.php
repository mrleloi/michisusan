<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>appdate-cms LOGIN</title>
    <style>
        .login{
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            margin: auto;
            background:url("{{ asset('img/bg_logo.png') }}") no-repeat ;
            background-position:center center; 
            background-size:contain;
            width:40%;  
            max-width: 500px;
            @media screen and (max-width: 768px) {
                width: 70%;
            }
        }
    </style>
</head>

<body>
    <div id="app" class="wrapper flex justify-center items-center h-lvh login">
        <div class="inline-block text-center w-full">
            <h1 class="mb-5"><img src="{{ asset('img/logo.png') }}" alt="appdate-cms" class="text-center inline"></h1>
            <form class="form" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <span class="relative">
                        <i class="pi pi-user absolute top-2/4 -mt-2 left-3 text-surface-400 dark:text-surface-600"></i>
                        <input-text type="email" size="small" name="email" placeholder="アカウント名"
                            class="!pl-10 max-w-96 min-w-40 w-full"></input-text>
                    </span>
                    <x-form-error for="email"></x-form-error>
                </div>
                <div class="mb-3">
                    <span class="relative">
                        <i class="pi pi-key absolute top-2/4 -mt-2 left-3 text-surface-400 dark:text-surface-600"></i>
                        <input-text type="password" size="small" name="password" placeholder="パスワード"
                            class="!pl-10 max-w-96 min-w-40 w-full"></input-text>
                    </span>
                    <x-form-error for="password"></x-form-error>
                </div>
                @if ($errors->has('other'))
                    <div class="inline-block bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <strong class="font-bold">エラー</strong>
                        @foreach($errors->get('other') as $error)
                            <span class="block sm:inline">{{ $error }}</span>
                        @endforeach
                    </div>
                @endif
                <div class="flex justify-center mt-10">
                    <pv-button label="ログイン" type="submit" severity="info" rounded size="small"
                        class="!px-10"></pv-button>
                </div>
            </form>
        </div>
    </div>
    <div class="fixed bottom-2 right-2"> ver.20241201</div>
</body>

</html>
