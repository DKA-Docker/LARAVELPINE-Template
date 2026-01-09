<?php

namespace App\Livewire\Metronic\Dashboards\Settings\Vehicles\Components;

use Livewire\Component;
use App\Services\Resources\Data\Vehicles\DataVehiclesServices;
use App\Services\Resources\Data\Vehicles\DataVehicleCategoriesServices;
use Illuminate\Support\Facades\Auth;

class CreateForm extends Component
{
    public $name;
    public $plate;
    public $category;

    public function render(DataVehicleCategoriesServices $service)
    {
        $categories = $service->GetDropdown();
        return view('dashboards.settings.vehicles.components.create-form', [
            'categories' => $categories
        ]);
    }

    public function store(DataVehiclesServices $service)
    {
        $this->validate([
            'name' => 'required',
            'plate' => 'required',
            'category' => 'required',
        ]);

        $service->Create([
            'name' => $this->name,
            'plate' => $this->plate,
            'category' => $this->category,
            'account' => Auth::id()
        ]);

        session()->flash('success', 'Vehicle created successfully.');
        return redirect()->route('dashboards.settings.vehicles.index');
    }
}
