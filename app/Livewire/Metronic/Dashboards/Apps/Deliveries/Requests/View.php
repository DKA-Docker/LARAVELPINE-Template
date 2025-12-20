<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Requests;

use AllowDynamicProperties;
use App\Services\Resources\Deliveries\Requests\ResourcesDeliveriesRequestsServices;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View as ViewContract;

#[AllowDynamicProperties]
class View extends Component
{
    use WithPagination;

    // Menggunakan tailwind pagination
    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $perPage = 5;
    public $status = '';
    public $sort = 'latest';

    public function boot(ResourcesDeliveriesRequestsServices $services)
    {
        $this->services = $services;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render(): ViewContract
    {
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
