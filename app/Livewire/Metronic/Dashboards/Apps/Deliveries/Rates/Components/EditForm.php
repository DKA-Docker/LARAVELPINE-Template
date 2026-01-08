<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Rates\Components;

use App\Services\Resources\Deliveries\Rates\ResourcesDeliveriesDataRatesCategoriesServices;
use App\Services\Resources\Deliveries\Rates\ResourcesDeliveriesDataRatesServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\Request;
use Livewire\Component;

class EditForm extends Component
{
    protected ResourcesDeliveriesDataRatesServices $ratesService;
    protected ResourcesDeliveriesDataRatesCategoriesServices $categoriesService;

    public $id;
    public $name = '';
    public $price = '';
    public $description = '';
    public $category_id = '';
    
    // New Category Properties
    public $category_mode = 'select'; // 'select' or 'new'
    public $new_category_name = '';
    public $new_category_description = '';

    public function boot(): void
    {
        $this->ratesService = new ResourcesDeliveriesDataRatesServices();
        $this->categoriesService = new ResourcesDeliveriesDataRatesCategoriesServices();
    }

    public function mount($id): void
    {
        $this->id = $id;
        $rate = $this->ratesService->query()->find($id);

        if ($rate) {
            $this->name = $rate->name;
            $this->price = $rate->price;
            $this->description = $rate->description;
            $this->category_id = $rate->category ?? '';
        }
    }

    public function toggleCategoryMode(): void
    {
        $this->category_mode = $this->category_mode === 'select' ? 'new' : 'select';
        $this->category_id = '';
        $this->new_category_name = '';
        $this->new_category_description = '';
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required_if:category_mode,select|nullable|exists:apps_deliveries_data_rates_categories,id',
            'new_category_name' => 'required_if:category_mode,new|nullable|string|max:255',
            'new_category_description' => 'nullable|string',
        ]);

        $finalCategoryId = $this->category_id;

        // Create new category if needed
        if ($this->category_mode === 'new') {
            $catRequest = new Request([
                'name' => $this->new_category_name,
                'description' => $this->new_category_description,
                'icon' => 'fa-box', // Default icon
            ]);
            
            $catResult = $this->categoriesService->Store($catRequest);
            
            if (!$catResult['status']) {
                $this->addError('new_category_name', 'Failed to create category: ' . $catResult['msg']);
                return;
            }
            
            $finalCategoryId = $catResult['data']->id; 
        }

        // Update Rate
        $rateRequest = new Request([
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'category' => $finalCategoryId,
        ]);

        $result = $this->ratesService->Update($rateRequest, $this->id);

        if ($result['status']) {
            return redirect()->route('dashboards.apps.deliveries.rates.index')->with('success', 'Rate updated successfully!');
        } else {
            $this->addError('name', 'Failed to update rate: ' . $result['msg']);
        }
    }

    public function render(): ViewContract|Factory
    {
        $categories = $this->categoriesService->query()->orderBy('name')->get();

        return view('dashboards.apps.deliveries.rates.components.edit-form', [
            'categories' => $categories
        ]);
    }
}
