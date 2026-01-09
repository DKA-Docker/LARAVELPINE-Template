<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Sessions;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasksAssigns;
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
        $assigns = AppsDeliveriesTasksAssigns::query()
            ->with(['task', 'assignedAccount.information'])
            ->latest()
            ->paginate($this->perPage);

        return view('dashboards.apps.deliveries.sessions.livewire-index', [
            'assigns' => $assigns
        ]);

    }

    public function placeholder()
    {
        return view('dashboards.layouts.placeholders.view');
    }
}
