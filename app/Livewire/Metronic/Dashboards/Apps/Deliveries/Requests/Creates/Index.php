<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Requests\Creates;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    /**
     * Data global form.
     */
    public array $data = [
        'title'        => null,
        'urgent'       => null,
        'destinations' => [], // ini akan di-bind ke child Destinations\ItemsLayout
    ];

    public function submit(): void
    {
        Debugbar::info('SUBMIT PAYLOAD', $this->data);
    }

    public function render(): Factory|View
    {
        return view('dashboards.apps.deliveries.requests.creates.index');
    }
}
