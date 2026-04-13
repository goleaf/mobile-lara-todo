<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class MobileHomeShell extends Component
{
    public string $headline = '';

    public string $supportingText = '';

    /**
     * @var array<int, array<string, string>>
     */
    public array $stats = [];

    /**
     * @var array<int, array<string, string>>
     */
    public array $quickActions = [];

    /**
     * @param  array<int, array<string, string>>  $stats
     * @param  array<int, array<string, string>>  $quickActions
     */
    public function mount(string $headline, string $supportingText, array $stats, array $quickActions): void
    {
        $this->headline = $headline;
        $this->supportingText = $supportingText;
        $this->stats = $stats;
        $this->quickActions = $quickActions;
    }

    public function render(): View
    {
        return view('livewire.mobile-home-shell');
    }
}
