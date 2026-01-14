<?php

namespace App\Livewire\Metronic\Dashboards\Settings\Vehicles\Components\View\Tabs;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Resources\Data\Vehicles\DataVehiclesServices;
use App\Services\Resources\Data\Vehicles\DataVehicleCategoriesServices;
use Illuminate\Support\Facades\Auth;

class Vehicle extends Component
{
    use WithPagination;

    // Search filters
    public $name = '';
    public $category = '';

    protected $listeners = ['refresh-list' => '$refresh'];

    public function render(DataVehiclesServices $vehicleService, DataVehicleCategoriesServices $categoryService)
    {
        $vehicles = $vehicleService->ReadAll([
            'name' => $this->name,
            'category' => $this->category
        ]);

        $categories = $categoryService->GetDropdown();

        return view('dashboards.settings.vehicles.components.view.tabs.vehicle', [
            'vehicles' => $vehicles,
            'categories' => $categories
        ]);
    }
}
