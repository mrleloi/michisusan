<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>

        @stack('meta')
        @stack('scripts')
        @stack('styles')

        @vite(['resources/css/front/common.css', 'resources/css/front/style.css', 'resources/js/app.js'])

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Noto+Serif+JP:wght@400;700&display=swap" rel="stylesheet">
    </head>
    <body>
        <div id="app" class="w-screen h-screen overflow-hidden" v-cloak>
            {{ $slot }}
        </div>
    </body>    
</html>