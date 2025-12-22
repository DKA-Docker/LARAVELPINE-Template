<?php

namespace App\Livewire\Metronic\Dashboards\Layouts\Placeholders;

use Livewire\Component;

class View extends Component
{
    public function render()
    {
        // Simulasi loading (opsional untuk testing)
        // sleep(1);

        return view('dashboards.layouts.placeholders.view');
    }
}
