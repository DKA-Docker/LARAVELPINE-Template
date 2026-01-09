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

    public function render(DataVehicleCategoriesServices $service)
    {
        $categories = $service->ReadAll([
            'name' => $this->name
        ]);
        
        return view('dashboards.settings.vehicles.components.view.tabs.category', [
            'categories' => $categories
        ]);
    }

    public function delete($id, DataVehicleCategoriesServices $service)
    {
        $service->Delete($id);
        session()->flash('success', 'Category deleted successfully.');
    }
}
