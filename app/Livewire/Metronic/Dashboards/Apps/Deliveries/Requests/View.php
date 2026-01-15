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

    public $confirmingDeletion = false;
    public $deleteId = null;

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
        if (!Auth::user()->can('dashboards.apps.deliveries.requests.delete')) {
            session()->flash('error', 'Unauthorized action.');
            $this->cancelDelete();
            return;
        }

        if (!$this->deleteId) {
            return;
        }

        try {
            $response = $this->services->Delete($this->deleteId);
            if ($response['status']) {
                session()->flash('success', $response['msg']);
            } else {
                session()->flash('error', 'Failed to delete request: ' . $response['msg']);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }

        $this->confirmingDeletion = false;
        $this->deleteId = null;
    }

    public function render(): ViewContract
    {
        if (!$this->isAuthorized) {
            return view('dashboards.layouts.unauthorized');
        }

        $user = Auth::user();

        $query = $this->services->query()->with([
            'account.information',
            'account.contact',
            'destinations.packages'
        ]);

        // --- LOGIKA HAK AKSES (SUPERADMIN & ADMIN) ---
        // Jika user BUKAN superadmin dan BUKAN admin, filter berdasarkan user_id mereka sendiri
        if (!$user->hasAnyRole(['superadmin', 'admin'])) {
            // Asumsi kolom di tabel request adalah 'user_id' atau 'created_by'
            $query->where('account', $user->id);
        }
        // ----------------------------------------------

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

        $deliveries->through(function ($item) {
            $account = $item->getRelation('account');
            if ($account) {
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
