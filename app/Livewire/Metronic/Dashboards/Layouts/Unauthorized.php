<?php

namespace App\Livewire\Metronic\Dashboards\Layouts;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;
#[Lazy]
class Unauthorized extends Component
{
    public function render(): Factory|View
    {
        return view('dashboards.layouts.unauthorized');
    }
}
