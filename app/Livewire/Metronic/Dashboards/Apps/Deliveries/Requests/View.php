<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Requests;

use App\Services\Resources\Deliveries\Requests\ResourcesDeliveriesRequestsServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View as ViewContract;

#[Lazy]
class View extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    protected ResourcesDeliveriesRequestsServices $services;

    public $search = '';
    public $perPage = 10;
    public $status = '';
    public $sort = 'latest';
    public $customerName = '';
    public bool $isAuthorized = true;

    public function boot(): void
    {
        $this->services = new ResourcesDeliveriesRequestsServices();
    }

    public function mount(): void
    {
        if (!Auth::user()->can('dashboards.apps.deliveries.requests.view')) {
            $this->isAuthorized = false;
        }
    }

    public function updated($property): void
    {
        if (in_array($property, ['search', 'status', 'customerName'])) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'status', 'customerName']);
        $this->sort = 'latest';
        $this->resetPage();
    }

    public function placeholder(): Factory|ViewContract|\Illuminate\View\View
    {
        return view('dashboards.layouts.placeholders.view');
    }

    public function render(): ViewContract
    {
        if (!$this->isAuthorized) {
            return view('dashboards.layouts.unauthorized');
        }

        // INTEGRASI: Eager loading sesuai instruksi Anda
        $query = $this->services->query()->with([
            'account.information',
            'account.contact',
            'destinations.packages'
        ]);

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->customerName) {
            $query->whereHas('account.information', function ($q) {
                $q->where('first_name', 'like', '%' . $this->customerName . '%')
                    ->orWhere('last_name', 'like', '%' . $this->customerName . '%');
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $this->sort === 'latest' ? $query->latest() : $query->oldest();

        $deliveries = $query->paginate($this->perPage);

        // TRANSFORMATION: Tetap menggunakan through sesuai permintaan Anda
        $deliveries->through(function ($item) {
            $account = $item->getRelation('account');
            if ($account) {
                // Pertahankan bentuk nama object lama
                $item->account = $account;
                $item->account->information = $account->getRelationValue('information');
                $item->account->contact = $account->getRelationValue('contact');
            }
            return $item;
        });

        return view('dashboards.apps.deliveries.requests.view', [
            'deliveries' => $deliveries
        ]);
    }
}
