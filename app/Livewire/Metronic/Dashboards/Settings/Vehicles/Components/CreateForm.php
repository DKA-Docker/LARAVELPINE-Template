<?php

namespace App\Livewire\Metronic\Dashboards\Settings\Vehicles\Components;

use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Component;
use App\Services\Resources\Data\Vehicles\DataVehiclesServices;
use App\Services\Resources\Data\Vehicles\DataVehicleCategoriesServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CreateForm extends Component
{
    public $activeTab = 'details';
    public $name;
    public $plate;
    public $category;

    // Category form properties
    public $category_name;
    public $description;

    protected DataVehicleCategoriesServices $services;

    public  function boot(): void
    {
        $this->services = new DataVehicleCategoriesServices();
        $this->vehiclesServices = new DataVehiclesServices();
    }

    public function mount()
    {
        if (request()->query('tab') === 'category') {
            $this->activeTab = 'category';
        }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render(): View
    {
        $categories = $this->services->GetDropdown();
        return view('dashboards.settings.vehicles.components.create-form', [
            'categories' => $categories
        ]);
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'plate' => 'required',
            'category' => 'required',
        ]);

        $response = $this->vehiclesServices->Create([
            'name' => $this->name,
            'plate' => $this->plate,
            'category' => $this->category,
            'account' => Auth::id()
        ]);


        if ($response['status']) {
            // Flash ke session Laravel
            session()->flash('success', 'Vehicle created successfully.');
            return redirect()->route('dashboards.settings.vehicles.index');
        } else {
            $this->addError('submit', $response['msg'] ?? 'An error occurred while creating the vehicle.');
        }
    }

    public function storeCategory(DataVehicleCategoriesServices $service)
    {
        $this->validate([
            'category_name' => 'required',
        ]);

        $response = $service->Create([
            'name' => $this->category_name,
            'description' => $this->description,
            'account' => Auth::id()
        ]);

        $this->activeTab = 'details'; // Switch back to details after creating category
        $this->category_name = '';
        $this->description = '';

        if ($response['status']) {
            // Flash ke session Laravel
            session()->flash('success', 'Vehicle Category created successfully.');
            return redirect()->route('dashboards.settings.vehicles.index', ['tab' => 'categories']);
        } else {
            $this->addError('submit', $response['msg'] ?? 'An error occurred while creating the vehicle.');
        }

    }
}
