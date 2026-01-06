<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Rates;

use App\Services\Resources\Deliveries\Rates\ResourcesDeliveriesDataRatesServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Contracts\View\Factory;

class View extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    protected ResourcesDeliveriesDataRatesServices $services;

    public $search = '';
    public $perPage = 10;
    public $sort = 'latest';

    public function boot(): void
    {
        $this->services = new ResourcesDeliveriesDataRatesServices();

        Debugbar::info($this->services);
    }

    public function render(): ViewContract|Factory
    {
        $query = $this->services->query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        $this->sort === 'latest' ? $query->latest() : $query->oldest();

        $rates = $query->paginate($this->perPage);

        return view('dashboards.apps.deliveries.rates.view', [
            'rates' => $rates
        ]);
    }
}
