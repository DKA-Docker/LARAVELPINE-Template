<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Requests;

use AllowDynamicProperties;
use App\Services\Resources\Deliveries\Requests\ResourcesDeliveriesRequestsServices;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View as ViewContract;

class View extends Component
{
    use WithPagination;

    // Menggunakan tailwind pagination
    protected $paginationTheme = 'tailwind';
    protected ResourcesDeliveriesRequestsServices $services;

    public $search = '';
    public $perPage = 5;
    public $status = '';
    public $sort = 'latest';

    // Properti untuk mengecek izin tanpa throw error
    public bool $isAuthorized = true;

    public function boot(): void
    {
        $this->services = new ResourcesDeliveriesRequestsServices();
    }

    public function mount(): void
    {
        // Langsung lempar exception jika tidak punya izin
        if (!Auth::user()->can('dashboards.apps.deliveries.requests.view')) {
            $this->isAuthorized = false;
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render(): ViewContract
    {

        // Jika tidak ada izin, langsung kembalikan view khusus unauthorized
        if (!$this->isAuthorized) {
            return view('dashboards.layouts.unauthorized');
        }

        // Pastikan relasi di-eager load untuk performa
        $query = $this->services->query();

        // Logic Search menembus relasi
        if ($this->search) {
            $query->where(function ($mainQuery) {
                $mainQuery->whereHas('account.information', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                })->orWhereHas('account.contact', function ($q) {
                    $q->where('email', 'like', '%' . $this->search . '%');
                });
            });
        }

        // Filter Status
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Sorting
        $this->sort === 'latest' ? $query->latest() : $query->oldest();

        // Eksekusi Paginasi
        $deliveries = $query->paginate($this->perPage);

        // TRANSFORMATION: Menangani bentrokan nama kolom 'account' vs relasi 'account'
        $deliveries->through(function ($item) {
            // Ambil objek relasi secara paksa melewati properti string
            $account = $item->getRelation('account');

            // Simpan object relasi ke atribut dinamis agar bisa dipanggil langsung di Blade
            // Ini menghindari error "Attempt to read property on string"
            $item->information = $account->getRelationValue('information');
            $item->contact = $account->getRelationValue('contact');

            return $item;
        });

        return view('dashboards.apps.deliveries.requests.view', [
            'deliveries' => $deliveries
        ]);
    }
}
