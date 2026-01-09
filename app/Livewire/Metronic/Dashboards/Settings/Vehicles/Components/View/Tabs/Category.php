<?php

namespace App\Livewire\Metronic\Dashboards\Settings\Vehicles\Components\View\Tabs;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Resources\Data\Vehicles\DataVehiclesServices;
use App\Models\Data\Vehicles\DataVehicleCategories;
use Illuminate\Support\Facades\Auth;

class Category extends Component
{
    use WithPagination;

    public $name;
    public $description;
    public $editId = null;
    public $isModalOpen = false;

    public function render()
    {
        $categories = DataVehicleCategories::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboards.settings.vehicles.components.view.tabs.category', [
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
        ]);

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            // Account logic needs to be verified if checking strictness, but for now assuming handled or added
             'account' => Auth::id()
        ];

        if ($this->editId) {
            $service->updateCategory($this->editId, $data);
        } else {
            $service->createCategory($data);
        }

        $this->closeModal();
        $this->resetInputFields();
        session()->flash('success', $this->editId ? 'Category updated successfully.' : 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = DataVehicleCategories::find($id);
        $this->editId = $id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->isModalOpen = true;
    }

    public function delete($id, DataVehiclesServices $service)
    {
        $service->deleteCategory($id);
        session()->flash('success', 'Category deleted successfully.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->editId = null;
    }
}
