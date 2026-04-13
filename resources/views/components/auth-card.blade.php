@props([
    'title',
    'subtitle',
])

<section class="auth-card" aria-label="{{ $title }}">
    <div class="auth-card__header">
        <a href="{{ route('app.home') }}" class="auth-card__brand" wire:navigate>
            <span class="material-symbols-rounded" aria-hidden="true">check_circle</span>
            <span>{{ config('app.name', 'Material Todo') }}</span>
        </a>

        <p class="eyebrow">Built-in Laravel auth</p>
        <h1>{{ $title }}</h1>
        <p>{{ $subtitle }}</p>
    </div>

    <div class="auth-card__content">
        {{ $slot }}
    </div>
</section>
