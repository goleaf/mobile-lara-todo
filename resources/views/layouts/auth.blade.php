<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="theme-color" content="#fef7ff">

        <title>{{ $title ?? config('app.name', 'Material Todo') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,400,0,0&family=Roboto+Flex:opsz,wght@8..144,400;500;600;700&display=swap"
            rel="stylesheet"
        >

        <style>
            :root {
                --safe-area-top: env(safe-area-inset-top, 0px);
                --safe-area-right: env(safe-area-inset-right, 0px);
                --safe-area-bottom: env(safe-area-inset-bottom, 0px);
                --safe-area-left: env(safe-area-inset-left, 0px);
            }
        </style>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        @livewireStyles
    </head>
    <body>
        <main class="auth-page">
            {{ $slot }}
        </main>

        @livewireScripts
    </body>
</html>
