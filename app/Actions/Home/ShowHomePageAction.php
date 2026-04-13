<?php

namespace App\Actions\Home;

class ShowHomePageAction
{
    /**
     * @return array<string, mixed>
     */
    public function handle(): array
    {
        return [
            'title' => config('app.name', 'Material Todo'),
            'headline' => 'Plan today from a clean mobile-first shell.',
            'supportingText' => 'Laravel 13, Livewire 3, SQLite-backed sessions, and SQLite-backed cache are wired up and ready for the first todo flows.',
            'navigationItems' => [
                [
                    'label' => 'Today',
                    'icon' => 'today',
                    'href' => route('app.home'),
                    'current' => true,
                ],
                [
                    'label' => 'Upcoming',
                    'icon' => 'calendar_month',
                    'href' => '#',
                    'current' => false,
                ],
                [
                    'label' => 'Projects',
                    'icon' => 'dashboard_customize',
                    'href' => '#',
                    'current' => false,
                ],
            ],
            'stats' => [
                [
                    'label' => 'Database',
                    'value' => 'SQLite',
                    'description' => 'Primary application data lives in database/database.sqlite.',
                ],
                [
                    'label' => 'Sessions',
                    'value' => 'Database',
                    'description' => 'The default sessions table is enabled for local state.',
                ],
                [
                    'label' => 'Cache',
                    'value' => 'Database',
                    'description' => 'Cache entries and locks are persisted in SQLite tables.',
                ],
            ],
            'quickActions' => [
                [
                    'label' => 'New task',
                    'icon' => 'add_task',
                    'variant' => 'filled',
                ],
                [
                    'label' => 'Focus block',
                    'icon' => 'timer',
                    'variant' => 'tonal',
                ],
                [
                    'label' => 'Review inbox',
                    'icon' => 'inbox',
                    'variant' => 'outlined',
                ],
            ],
        ];
    }
}
