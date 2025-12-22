<?php

namespace App\Livewire\Metronic\Dashboards\Layouts\Constructors;

use Livewire\Component;

class HeadersSkeleton extends Component
{
    public function render()
    {
        // Simulasi loading (opsional untuk testing)
        // sleep(1);

        return view('dashboards.layouts.constructors.headers-skeleton');
    }
}
