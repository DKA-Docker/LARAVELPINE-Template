<?php

namespace App\Livewire\Metronic\Dashboards\Managements\Accounts\Particles\Headings;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;


class Headings extends Component
{

    public function placeholder(): Factory|ViewContract|\Illuminate\View\View
    {
        return view('dashboards.managements.accounts.particles.headings.headings-skeleton');
    }
    public function render(): Factory|View
    {
        return view('dashboards.managements.accounts.particles.headings.headings');
    }
}
