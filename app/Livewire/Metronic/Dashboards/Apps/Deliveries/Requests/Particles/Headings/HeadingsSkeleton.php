<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Requests\Particles\Headings;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\Lazy;


#[Lazy]
class HeadingsSkeleton extends Component
{

    public function render(): Factory|View
    {
        return view('dashboards.apps.deliveries.requests.particles.headings.headings-skeleton');
    }
}
