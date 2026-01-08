<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Rates;

use App\Services\Resources\Deliveries\Rates\ResourcesDeliveriesDataRatesCategoriesServices;
use App\Services\Resources\Deliveries\Rates\ResourcesDeliveriesDataRatesServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\Request;
use Livewire\Component;

class Edit extends Component
{
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function render(): ViewContract|Factory
    {
        return view('dashboards.apps.deliveries.rates.components.edit-form', [
            'id' => $this->id
        ]);
    }
}
