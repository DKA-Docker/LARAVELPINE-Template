<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Sessions;

use App\Models\Apps\Deliveries\Sessions\AppsDeliveriesSessions;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function render()
    {
        $sessions = AppsDeliveriesSessions::query()
            ->latest()
            ->paginate($this->perPage);

        return view('dashboards.apps.deliveries.sessions.view', [
            'sessions' => $sessions
        ]);
    }

    public function placeholder()
    {
        return view('dashboards.layouts.placeholders.view');
    }
}
