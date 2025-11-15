<?php

namespace App\Livewire\Metronic\Dashboards\Layouts\Constructors\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Menu extends Component
{
    public function render(): Factory|View
    {
        return view('dashboards.layouts.constructors.components.menu');
    }
}
