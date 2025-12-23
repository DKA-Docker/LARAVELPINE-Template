<?php

namespace App\Livewire\Metronic\Dashboards\Layouts\Constructors\Components;

use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy]
class MenuSkeleton extends Component
{
    public function render()
    {
        // Simulasi loading (opsional untuk testing)
        // sleep(1);

        return view('dashboards.layouts.constructors.components.menu-skeleton');
    }
}
