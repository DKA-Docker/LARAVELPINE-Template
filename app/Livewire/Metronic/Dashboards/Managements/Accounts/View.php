<?php

namespace App\Livewire\Metronic\Dashboards\Managements\Accounts;

use App\Services\Resources\Accounts\ResourcesAccountsServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;
#[Lazy]
class View extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    protected ResourcesAccountsServices $services;

    // Filter Properties
    public $search = '';
    public $perPage = 10;
    public $status = '';
    public $sort = 'latest';
    public $customerName = '';
    public $recipientName = '';
    public $minPackages = null;
    public $maxPackages = null;

    // Delete Confirmation
    public $confirmingDeletion = false;
    public $accountIdToDelete = '';

    public bool $isAuthorized = true;

    public function boot(): void
    {
        $this->services = new ResourcesAccountsServices();
    }

    public function mount(): void
    {
        // Pengecekan otorisasi menggunakan Spatie/Laravel Gate
        if (!Auth::user()->can('dashboards.managements.accounts.view')) {
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
        $this->reset(['search', 'status', 'customerName', 'recipientName', 'minPackages', 'maxPackages']);
        $this->sort = 'latest';
        $this->resetPage();
    }

    public function confirmDelete($id): void
    {
        $this->confirmingDeletion = true;
        $this->accountIdToDelete = $id;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeletion = false;
        $this->accountIdToDelete = '';
    }

    public function deleteConfirmed(): void
    {
        $result = $this->services->Delete($this->accountIdToDelete);

        if ($result['status']) {
            session()->flash('success', $result['msg']);
        } else {
            session()->flash('error', $result['msg']);
        }

        $this->confirmingDeletion = false;
        $this->accountIdToDelete = '';
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

        // Query Utama dengan Eager Loading relasi termasuk Spatie Roles
        $query = $this->services->query()->with([
            'credential',
            'contact',
            'information',
            'firebase',
            'roles' // Relasi Spatie: 'roles' (hasMany/belongsToMany)
        ]);

        // Logika Global Search (Mencari di Informasi Nama dan Username)
        if($this->search){
            $query->where(function($mainQuery) {
                $mainQuery->whereHas('information', function($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                })->orWhereHas('credential', function($q) {
                    $q->where('username', 'like', '%' . $this->search . '%');
                })->orWhereHas('contact', function($q) {
                    $q->where('email', 'like', '%' . $this->search . '%');
                });
            });
        }

        // Sorting
        $this->sort === 'latest' ? $query->latest() : $query->oldest();

        // Eksekusi Pagination
        $acc = $query->paginate($this->perPage);

        /**
         * KONSEP THROUGH (TRANSFORMASI DATA)
         * Menggabungkan data relasi menjadi objek properti tunggal
         * dan mengekstrak Spatie Role untuk kemudahan di Blade.
         */
        $acc->through(function ($item) {
            // Mapping relasi dasar
            $item->credential  = $item->getRelation('credential');
            $item->contact     = $item->getRelation('contact');
            $item->information = $item->getRelation('information');
            $item->firebase    = $item->getRelation('firebase');

            // Logika Khusus Spatie: Mengambil role pertama untuk ditampilkan sebagai 'role' objek
            // Kita transformasikan agar Blade hanya memanggil $item->role->name
            $spatieRoles = $item->getRelation('roles');
            $item->role = $spatieRoles->first() ? (object) [
                'name' => $spatieRoles->first()->name,
                'guard_name' => $spatieRoles->first()->guard_name
            ] : null;

            return $item;
        });

        Debugbar::log($acc);

        return view('dashboards.managements.accounts.view', [
            'acc' => $acc
        ]);
    }
}
