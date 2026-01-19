<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Components\Particles\Headings;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;
#[Lazy]
class Headings extends Component
{

    public function placeholder(): Factory|ViewContract|View
    {
        return view('dashboards.apps.deliveries.tasks.components.particles.headings.headings-skeleton');
    }
    public function render(): Factory|View
    {
        return view('dashboards.apps.deliveries.tasks.components.particles.headings.headings');
    }
}
