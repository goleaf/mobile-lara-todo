<section class="content-stack">
    <article class="hero-card">
        <div class="hero-copy">
            <p class="eyebrow">Laravel 13 + Livewire 3</p>
            <h2>{{ $headline }}</h2>
            <p>{{ $supportingText }}</p>
        </div>

        <div class="hero-actions">
            @foreach ($quickActions as $quickAction)
                @if ($quickAction['variant'] === 'filled')
                    <md-filled-button>
                        <md-icon slot="icon">{{ $quickAction['icon'] }}</md-icon>
                        {{ $quickAction['label'] }}
                    </md-filled-button>
                @elseif ($quickAction['variant'] === 'tonal')
                    <md-filled-tonal-button>
                        <md-icon slot="icon">{{ $quickAction['icon'] }}</md-icon>
                        {{ $quickAction['label'] }}
                    </md-filled-tonal-button>
                @else
                    <md-outlined-button>
                        <md-icon slot="icon">{{ $quickAction['icon'] }}</md-icon>
                        {{ $quickAction['label'] }}
                    </md-outlined-button>
                @endif
            @endforeach
        </div>

        <div class="hero-fab">
            <md-fab aria-label="Create task">
                <md-icon slot="icon">add</md-icon>
            </md-fab>
        </div>
    </article>

    <section class="stats-grid" aria-label="Application setup overview">
        @foreach ($stats as $stat)
            <article class="stat-card">
                <p class="stat-card__label">{{ $stat['label'] }}</p>
                <p class="stat-card__value">{{ $stat['value'] }}</p>
                <p class="stat-card__description">{{ $stat['description'] }}</p>
            </article>
        @endforeach
    </section>

    <section class="panel-card">
        <div class="panel-card__header">
            <div>
                <p class="eyebrow">Ready for todo features</p>
                <h2>Base mobile shell is in place</h2>
            </div>

            <md-assist-chip label="No auth yet">
                <md-icon slot="icon">lock_open</md-icon>
            </md-assist-chip>
        </div>

        <ul class="feature-list">
            <li>SQLite powers the primary database file in <code>database/database.sqlite</code>.</li>
            <li>Sessions and cache use database-backed Laravel drivers.</li>
            <li>Material Web Components load from CDN and stay responsive on phones first.</li>
        </ul>
    </section>
</section>
