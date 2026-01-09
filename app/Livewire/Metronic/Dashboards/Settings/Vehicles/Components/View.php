<?php

namespace App\Livewire\Metronic\Dashboards\Settings\Vehicles\Components;

use Livewire\Component;

class View extends Component
{
    public $activeTab = 'vehicles';

    public function mount()
    {
        // Set default tab or from query string
        $this->activeTab = request()->query('tab', 'vehicles');
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('dashboards.settings.vehicles.components.view');
    }
}
