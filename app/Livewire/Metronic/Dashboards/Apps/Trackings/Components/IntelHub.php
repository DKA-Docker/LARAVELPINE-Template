<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Trackings\Components;

use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy]
class IntelHub extends Component
{
    public function render()
    {
        return view('dashboards.apps.trackings.components.intel-hub');
    }

    public function placeholder()
    {
        return view('dashboards.apps.trackings.components.intel-hub-skeleton');
    }
}
