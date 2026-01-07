<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Components\View\Tabs;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTasksServices;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Assigned extends Component
{
    public array $task;

    public function mount(array $task)
    {
        $this->task = $task;
    }

    public function placeholder()
    {
        return view('dashboards.apps.deliveries.tasks.components.view.tabs.assigned-skeleton');
    }

    public function render()
    {
        return view('dashboards.apps.deliveries.tasks.components.view.tabs.assigned', [
            'task' => $this->task
        ]);
    }
}
