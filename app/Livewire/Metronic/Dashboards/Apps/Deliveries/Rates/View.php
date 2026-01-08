<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Rates;

use App\Services\Resources\Deliveries\Rates\ResourcesDeliveriesDataRatesCategoriesServices;
use App\Services\Resources\Deliveries\Rates\ResourcesDeliveriesDataRatesServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Contracts\View\Factory;

class View extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    protected ResourcesDeliveriesDataRatesServices $services;
    protected ResourcesDeliveriesDataRatesCategoriesServices $categoriesServices;

    public $search = '';
    public $perPage = 10;
    public $sort = 'latest';

    // Filters
    public $category_id = '';
    public $minPrice = '';
    public $maxPrice = '';

    public function boot(): void
    {
        $this->services = new ResourcesDeliveriesDataRatesServices();
        $this->categoriesServices = new ResourcesDeliveriesDataRatesCategoriesServices();
    }

    public $confirmingDeletion = false;
    public $deleteId = null;

    public function resetFilters(): void
    {
        $this->search = '';
        $this->category_id = '';
        $this->minPrice = '';
        $this->maxPrice = '';
        $this->sort = 'latest';
        $this->resetPage();
    }

    public function confirmDelete(string $id): void
    {
        $this->deleteId = $id;
        $this->confirmingDeletion = true;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeletion = false;
        $this->deleteId = null;
    }

    public function deleteConfirmed(): void
    {
        if (!$this->deleteId) {
            return;
        }

        $result = $this->services->Delete($this->deleteId);

        if ($result['status']) {
            session()->flash('success', 'Rate deleted successfully!');
        } else {
            session()->flash('error', 'Failed to delete rate: ' . $result['msg']);
        }

        $this->confirmingDeletion = false;
        $this->deleteId = null;
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function render(): ViewContract|Factory
    {
        $query = $this->services->query()
                ->with([
                    'category_rel'
                ]);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('category_rel', function ($qCat) {
                      $qCat->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->category_id) {
            $query->where('category', $this->category_id);
        }

        if ($this->minPrice) {
            $query->where('price', '>=', $this->minPrice);
        }

        if ($this->maxPrice) {
            $query->where('price', '<=', $this->maxPrice);
        }

        switch ($this->sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            default: // latest
                $query->latest();
                break;
        }

        $rates = $query->paginate($this->perPage);

        // Fetch categories for dropdown
        // Assuming ReadAll returns correct structure, or we use repository query directly if needed
        // Assuming ReadAll functionality based on naming convention
        // Or simpler: accessing model directly since Services usually wrap logic
        // But to stick to pattern, let's try to fetch all.
        // For dropdowns, usually we just need ID and Name.
        $categories = $this->categoriesServices->query()->orderBy('name')->get();

        return view('dashboards.apps.deliveries.rates.view', [
            'rates' => $rates,
            'categories' => $categories
        ]);
    }
}
