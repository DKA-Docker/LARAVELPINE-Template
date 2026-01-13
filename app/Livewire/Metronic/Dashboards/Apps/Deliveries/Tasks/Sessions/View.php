<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Sessions;

use App\Models\Apps\Deliveries\Tasks\Sessions\AppsDeliveriesTasksSessions;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class View extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function render()
    {
        $sessions = AppsDeliveriesTasksSessions::query()
            ->latest()
            ->paginate($this->perPage);

        return view('dashboards.apps.deliveries.tasks.sessions.view', [
            'sessions' => $sessions
        ]);
    }

    public ?AppsDeliveriesTasksSessions $selectedSession = null;

    public function showTracking(string $id): void
    {
        $this->selectedSession = AppsDeliveriesTasksSessions::with(['account.credential', 'task', 'account.information'])->find($id);
    }

    public function closeTracking(): void
    {
        $this->selectedSession = null;
    }

    public function placeholder()
    {
        return view('dashboards.layouts.placeholders.view');
    }
}
