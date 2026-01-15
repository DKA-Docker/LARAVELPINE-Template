<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Components;

use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTasksServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

//#[Lazy]
class View extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    protected ResourcesDeliveriesTasksServices $services;

    // Filter Properties
    public $search = '';
    public $perPage = 10;
    public $status = '';
    public $sort = 'latest';
    public $customerName = '';
    public $recipientName = '';
    public $minPackages = null;
    public $maxPackages = null;

    // confirm delete propetries
    public $confirmingDeletion = false;
    public $deleteId = null;

    public bool $isAuthorized = true;

    public function boot(): void
    {
        $this->services = new ResourcesDeliveriesTasksServices();
    }

    public function mount(): void
    {
        if (!Auth::user()->can('dashboards.apps.deliveries.tasks.view')) {
            $this->isAuthorized = false;
        }
    }

    public function updated($property): void
    {
        if (in_array($property, ['search', 'status', 'customerName', 'recipientName', 'minPackages', 'maxPackages'])) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'status',
            'customerName',
            'recipientName',
            'minPackages',
            'maxPackages'
        ]);

        // Reset sorting ke default jika diinginkan
        $this->sort = 'latest';

        // Penting: Reset halaman ke 1
        $this->resetPage();
    }

    public function placeholder(): Factory|ViewContract|\Illuminate\View\View
    {
        return view('dashboards.layouts.placeholders.view');
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
        if (!Auth::user()->can('dashboards.apps.deliveries.tasks.delete')) {
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
                 session()->flash('error', 'Failed to delete task: ' . $response['msg']);
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

        $query = $this->services->query()
            ->with([
                'destination.request.account.information',
                'destination.packages',
                'history.account.information'
            ]);

        // --- LOGIKA HAK AKSES ---
        // Jika bukan superadmin/admin, filter hanya data milik user tersebut
        if (!$user->hasAnyRole(['superadmin', 'admin'])) {
            // Berdasarkan migration Anda, kolom foreign key ke tabel accounts adalah 'account'
            $query->where('account', $user->id);
        }

        // Global Search
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Filter Status
        if ($this->status) {
            $query->whereHas('history', function ($q) {
                $q->where('to_status', $this->status);
            });
        }

        // Filter Nama Customer (Hanya diproses jika destination ada)
        if ($this->customerName) {
            $query->whereHas('destination.request.account.information', function ($q) {
                $q->where('first_name', 'like', '%' . $this->customerName . '%')
                    ->orWhere('last_name', 'like', '%' . $this->customerName . '%');
            });
        }

        // Filter Nama Penerima
        if ($this->recipientName) {
            $query->whereHas('destination', function ($q) {
                $q->where('receipt_name', 'ilike', '%' . $this->recipientName . '%');
            });
        }

        // Filter Range Paket
        if ($this->minPackages !== null && $this->minPackages !== '') {
            $query->whereHas('destination.packages', function($q) {}, '>=', (int)$this->minPackages);
        }
        if ($this->maxPackages !== null && $this->maxPackages !== '') {
            $query->whereHas('destination.packages', function($q) {}, '<=', (int)$this->maxPackages);
        }

        $this->sort === 'latest' ? $query->latest() : $query->oldest();
        $tasks = $query->paginate($this->perPage);

        // Transformasi Data dengan pengecekan null safety
        $tasks->through(function ($item) {
            $item->account_relation = $item->getRelation('account'); // Hindari konflik nama kolom 'account'
            $item->history = $item->getRelation('history');

            // Menggunakan getRelation agar tetap efisien (Eager Loaded)
            $destination = $item->getRelation('destination');

            if ($destination) {
                $request = $destination->getRelationValue('request');
                if ($request) {
                    $reqAccount = $request->getRelationValue('account');
                    if ($reqAccount) {
                        $reqAccount->information = $reqAccount->getRelationValue('information');
                        $request->account = $reqAccount;
                    }
                    $destination->request = $request;
                }
                $destination->packages = $destination->getRelationValue('packages');
                $item->destination = $destination;
            } else {
                // Jika destination null, pastikan properti tetap ada agar view tidak error
                $item->destination = null;
            }

            return $item;
        });

        return view('dashboards.apps.deliveries.tasks.components.view', [
            'tasks' => $tasks
        ]);
    }
}
