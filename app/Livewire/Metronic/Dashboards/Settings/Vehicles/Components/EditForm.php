<?php

namespace App\Livewire\Metronic\Dashboards\Settings\Vehicles\Components;

use Livewire\Component;
use App\Services\Resources\Data\Vehicles\DataVehiclesServices;
use App\Services\Resources\Data\Vehicles\DataVehicleCategoriesServices;
use Illuminate\Support\Facades\Auth;

class EditForm extends Component
{
    public $vehicleId;
    public $name;
    public $plate;
    public $category;

    public function mount($vehicleId, DataVehiclesServices $service)
    {
        $this->vehicleId = $vehicleId;
        $vehicle = $service->Find($vehicleId);
        
        $this->name = $vehicle->name;
        $this->plate = $vehicle->plate;
        $this->category = $vehicle->categoryDetail->id ?? $vehicle->category;
    }

    public function render(DataVehicleCategoriesServices $service)
    {
        $categories = $service->GetDropdown();
        return view('dashboards.settings.vehicles.components.edit-form', [
            'categories' => $categories
        ]);
    }

    public function update(DataVehiclesServices $service)
    {
        $this->validate([
            'name' => 'required',
            'plate' => 'required',
            'category' => 'required',
        ]);

        $service->Update($this->vehicleId, [
            'name' => $this->name,
            'plate' => $this->plate,
            'category' => $this->category,
        ]);

        session()->flash('success', 'Vehicle updated successfully.');
        return redirect()->route('dashboards.settings.vehicles.index');
    }
}
