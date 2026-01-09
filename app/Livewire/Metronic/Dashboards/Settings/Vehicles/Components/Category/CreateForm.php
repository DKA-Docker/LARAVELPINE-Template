<?php

namespace App\Livewire\Metronic\Dashboards\Settings\Vehicles\Components\Category;

use Livewire\Component;
use App\Services\Resources\Data\Vehicles\DataVehicleCategoriesServices;
use Illuminate\Support\Facades\Auth;

class CreateForm extends Component
{
    public $name;
    public $description;

    public function render()
    {
        return view('dashboards.settings.vehicles.components.category.create-form');
    }

    public function store(DataVehicleCategoriesServices $service)
    {
        $this->validate([
            'name' => 'required',
        ]);

        $service->Create([
            'name' => $this->name,
            'description' => $this->description,
            'account' => Auth::id()
        ]);

        session()->flash('success', 'Category created successfully.');
        return redirect()->route('dashboards.settings.vehicles.categories.index');
    }
}
