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

        <script type="module" src="https://esm.run/@material/web/all.js"></script>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        @livewireStyles
    </head>
    <body>
        <div class="app-shell">
            <header class="top-bar">
                <div>
                    <p class="top-bar__eyebrow">Material Design 3</p>
                    <h1 class="top-bar__title">{{ $title ?? config('app.name', 'Material Todo') }}</h1>
                </div>

                <div class="top-bar__actions" aria-label="Shell actions">
                    <md-outlined-icon-button aria-label="Search">
                        <md-icon>search</md-icon>
                    </md-outlined-icon-button>

                    <md-filled-icon-button aria-label="Tune shell">
                        <md-icon>tune</md-icon>
                    </md-filled-icon-button>
                </div>
            </header>

            <main class="app-main">
                @yield('content')
            </main>

            <nav class="bottom-nav" aria-label="Primary navigation">
                @foreach ($navigationItems as $navigationItem)
                    <a
                        class="bottom-nav__link {{ $navigationItem['current'] ? 'is-active' : '' }}"
                        href="{{ $navigationItem['href'] }}"
                        @if ($navigationItem['current']) aria-current="page" @endif
                    >
                        <span class="material-symbols-rounded" aria-hidden="true">{{ $navigationItem['icon'] }}</span>
                        <span>{{ $navigationItem['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        @livewireScripts
    </body>
</html>
