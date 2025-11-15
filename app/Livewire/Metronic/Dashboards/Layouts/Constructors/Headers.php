<?php

namespace App\Livewire\Metronic\Dashboards\Layouts\Constructors;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Headers extends Component
{
    public function render(): Factory|View
    {
        return view('dashboards.layouts.constructors.headers');
    }
}
