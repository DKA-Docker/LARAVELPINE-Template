<?php

namespace App\Livewire\Metronic\Dashboards;

use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy]
class Overview extends Component
{
    public function placeholder()
    {
        return view('dashboards.components.overview-skeleton');
    }

    public function render()
    {
        return view('dashboards.components.overview');
    }
}
