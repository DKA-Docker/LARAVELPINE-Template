<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Components;

use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTasksServices;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use Livewire\Component;

class Detail extends Component
{
    public string $taskId;
    public string $activeTab = 'general'; // Default tab

    public array $task;

    protected ResourcesDeliveriesTasksServices $service;

    public function boot(ResourcesDeliveriesTasksServices $service)
    {
        $this->service = $service;
    }

    public function mount($taskId)
    {
        $this->taskId = $taskId;
        $this->loadTask();
    }

    public function loadTask()
    {
        $taskModel = $this->service->FindByID($this->taskId);

        if (!$taskModel) {
            abort(404);
        }

        // Load deep relations for all tabs and header
        $taskModel->load([
            'assigned.information',
            'assigned.contact',
            'geos',
            'history.account.information',
            'destination.request.account.information',
            'vehicle'
        ]);
        $this->task = $taskModel->toArray();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('dashboards.apps.deliveries.tasks.components.detail');
    }
}
