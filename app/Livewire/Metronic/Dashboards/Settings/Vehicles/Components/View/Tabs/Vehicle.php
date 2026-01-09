<?php

namespace App\Livewire\Metronic\Dashboards\Settings\Vehicles\Components\View\Tabs;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Resources\Data\Vehicles\DataVehiclesServices;
use App\Models\Data\Vehicles\DataVehicleCategories;
use App\Models\Data\Vehicles\DataVehicles;
use Illuminate\Support\Facades\Auth;

class Vehicle extends Component
{
    use WithPagination;

    // Form inputs
    public $name;
    public $plate;
    public $category;
    public $editId = null;

    // UI state
    public $isModalOpen = false;

    public function render(DataVehiclesServices $service)
    {
        $vehicles = DataVehicles::with('categoryDetail')->orderBy('created_at', 'desc')->paginate(10);
        $categories = DataVehicleCategories::orderBy('name')->get();

        return view('dashboards.settings.vehicles.components.view.tabs.vehicle', [
            'vehicles' => $vehicles,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function store(DataVehiclesServices $service)
    {
        $this->validate([
            'name' => 'required',
            'plate' => 'required',
            'category' => 'required',
        ]);

        $data = [
            'name' => $this->name,
            'plate' => $this->plate,
            'category' => $this->category,
            'account' => Auth::id()
        ];

        if ($this->editId) {
            $service->updateVehicle($this->editId, $data);
        } else {
            $service->createVehicle($data);
        }

        $this->closeModal();
        $this->resetInputFields();
        session()->flash('success', $this->editId ? 'Vehicle updated successfully.' : 'Vehicle created successfully.');
    }

    public function edit($id)
    {
        $vehicle = DataVehicles::find($id);
        if ($vehicle) {
            $this->editId = $id;
            $this->name = $vehicle->name;
            $this->plate = $vehicle->plate;
            $this->category = $vehicle->category->id ?? $vehicle->category;
            $this->isModalOpen = true;
        }
    }

    public function delete($id, DataVehiclesServices $service)
    {
        $service->deleteVehicle($id);
        session()->flash('success', 'Vehicle deleted successfully.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->plate = '';
        $this->category = '';
        $this->editId = null;
    }
}
