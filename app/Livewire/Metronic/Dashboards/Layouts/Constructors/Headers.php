<?php

namespace App\Livewire\Metronic\Dashboards\Layouts\Constructors;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Headers extends Component
{

    public function placeholder(): Factory|View
    {
        return view('dashboards.layouts.constructors.headers-skeleton');
    }
    public function render(): Factory|View
    {
        return view('dashboards.layouts.constructors.headers');
    }
}
