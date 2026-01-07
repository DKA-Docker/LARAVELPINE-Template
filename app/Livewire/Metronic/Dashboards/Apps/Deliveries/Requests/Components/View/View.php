<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Requests\Components\View;

use App\Services\Resources\Deliveries\Requests\ResourcesDeliveriesRequestsServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class View extends Component
{
    protected ResourcesDeliveriesRequestsServices $services;

    public $requestId;
    public $request;
    public bool $isAuthorized = true;

    public function boot(): void
    {
        $this->services = new ResourcesDeliveriesRequestsServices();
    }

    public function mount($requestId): void
    {
        if (!Auth::user()->can('dashboards.apps.deliveries.requests.view')) {
            $this->isAuthorized = false;
        }

        $this->requestId = $requestId;
    }

    public function render(): Factory|ViewContract
    {
        if (!$this->isAuthorized) {
            return view('dashboards.layouts.unauthorized');
        }

        $this->request = $this->services->Find($this->requestId);

        return view('dashboards.apps.deliveries.requests.components.view.view', [
            'request' => $this->request
        ]);
    }
}
