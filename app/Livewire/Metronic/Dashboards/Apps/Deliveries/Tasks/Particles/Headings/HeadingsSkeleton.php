<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Particles\Headings;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Livewire\Component;


class HeadingsSkeleton extends Component
{

    public function render(): Factory|View
    {
        return view('dashboards.apps.deliveries.tasks.particles.headings.headings-skeleton');
    }
}
