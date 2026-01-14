<?php

namespace App\Livewire\Metronic\Dashboards\Settings\Vehicles\Components\View\Tabs;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Resources\Data\Vehicles\DataVehicleCategoriesServices;
use Illuminate\Support\Facades\Auth;

class Category extends Component
{
    use WithPagination;

    public $name = '';

    protected $listeners = ['refresh-list' => '$refresh'];

    public function render(DataVehicleCategoriesServices $service)
    {
        $categories = $service->ReadAll([
            'name' => $this->name
        ]);
        
        return view('dashboards.settings.vehicles.components.view.tabs.category', [
            'categories' => $categories
        ]);
    }
}
