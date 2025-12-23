<?php

namespace App\Livewire\Metronic\Dashboards\Layouts\Constructors;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;

class Footers extends Component
{
    public function render(): Factory|View
    {
        return view('dashboards.layouts.constructors.footers');
    }
}
