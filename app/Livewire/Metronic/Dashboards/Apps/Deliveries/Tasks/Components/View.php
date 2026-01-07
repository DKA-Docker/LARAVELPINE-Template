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

    public function delete($id)
    {
        if (!Auth::user()->can('dashboards.apps.deliveries.tasks.delete')) {
             $this->dispatch('alert', ['type' => 'error', 'message' => 'Unauthorized action.']);
             return;
        }

        try {
            $response = $this->services->Delete($id);
            if ($response['code'] == 200) {
                 $this->dispatch('alert', ['type' => 'success', 'message' => 'Task deleted successfully.']);
            } else {
                 $this->dispatch('alert', ['type' => 'error', 'message' => 'Failed to delete task.']);
            }
        } catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function render(): ViewContract
    {
        if (!$this->isAuthorized) {
            return view('dashboards.layouts.unauthorized');
        }

        $query = $this->services->query()
            ->with([
            'destination.request.account.information',
            'destination.packages',
            'history.account.information'
        ]);

        // Global Search
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Filter Status (Mencari status terbaru di tabel history)
        if ($this->status) {
            $query->whereHas('history', function ($q) {
                $q->where('to_status', $this->status);
            });
        }

        // Filter Nama Customer (Requester)
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
            $query->whereHas('destination.packages', function($q) {}, '>=', $this->minPackages);
        }
        if ($this->maxPackages !== null && $this->maxPackages !== '') {
            $query->whereHas('destination.packages', function($q) {}, '<=', $this->maxPackages);
        }

        $this->sort === 'latest' ? $query->latest() : $query->oldest();
        $tasks = $query->paginate($this->perPage);

        // KUNCI: Pertahankan transformasi manual agar properti account & destination terbaca sebagai objek
        $tasks->through(function ($item) {
            $item->account = $item->getRelation('account');
            $item->history = $item->getRelation('history');

            $item->destination = $item->getRelation('destination');
            if ($item->destination) {
                $item->destination->request = $item->destination->getRelationValue('request');
                if ($item->destination->request) {
                    $item->destination->request->account = $item->destination->request->getRelationValue('account');
                    if ($item->destination->request->account) {
                        $item->destination->request->account->information = $item->destination->request->account->getRelationValue('information');
                    }
                }
                $item->destination->packages = $item->destination->getRelationValue('packages');
            }

            return $item;
        });

        Debugbar::error($tasks);

        return view('dashboards.apps.deliveries.tasks.components.view', [
            'tasks' => $tasks
        ]);
    }
}
