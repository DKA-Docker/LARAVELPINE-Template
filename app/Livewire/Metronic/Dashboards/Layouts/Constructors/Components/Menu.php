<?php

namespace App\Livewire\Metronic\Dashboards\Layouts\Constructors\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\View as ViewContract;
use Livewire\Attributes\Lazy;
use Livewire\Component;


#[Lazy]
class Menu extends Component
{

    public function placeholder(): Factory|ViewContract|\Illuminate\View\View
    {
        return view('dashboards.layouts.constructors.components.menu-skeleton');
    }
    public function render(): Factory|View
    {
        return view('dashboards.layouts.constructors.components.menu');
    }
}
