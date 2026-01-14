<?php

namespace App\Livewire\Metronic\Dashboards\Settings\Vehicles\Components\Category;

use Livewire\Component;
use App\Services\Resources\Data\Vehicles\DataVehicleCategoriesServices;
use Illuminate\Support\Facades\Auth;

class EditForm extends Component
{
    public $categoryId;
    public $name;
    public $description;

    public function mount($categoryId, DataVehicleCategoriesServices $service)
    {
        $this->categoryId = $categoryId;
        $category = $service->Find($categoryId);

        $this->name = $category->name;
        $this->description = $category->description;
    }

    public function render()
    {
        return view('dashboards.settings.vehicles.components.category.edit-form');
    }

    public function update(DataVehicleCategoriesServices $service)
    {
        $this->validate([
            'name' => 'required',
        ]);

        $service->Update($this->categoryId, [
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Category updated successfully.');
        return redirect()->route('dashboards.settings.vehicles.index', ['tab' => 'categories']);
    }
}
