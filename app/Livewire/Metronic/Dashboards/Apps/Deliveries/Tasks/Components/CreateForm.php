<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Components;

use App\Services\Resources\Accounts\ResourcesAccountsServices;
use App\Services\Resources\Deliveries\Requests\Destinations\ResourcesDeliveriesRequestsDestinationsServices;
use Illuminate\View\View;
use Livewire\Component;

class CreateForm extends Component
{
    public $perPage = 5; // Tambahkan ini
    // Properti utama untuk menampung seluruh data form
    public $formData = [
        'task_name'   => '',
        'destination' => '',
        'drivers'     => [],
        'latitude'    => -6.2088, // Berikan nilai default (contoh: Jakarta)
        'longitude'   => 106.8456,
    ];
    public $currentPage = 1; // Tambahkan ini
    public $destinations = [];
    // Properti di dalam class
    public $provinces = [];
    public $regencies = [];
    public $districts = [];
    public $villages  = [];
    public $driverSearch = '';

    protected ResourcesDeliveriesRequestsDestinationsServices $destService;
    protected ResourcesAccountsServices $accountsServices;

    public function boot(): void
    {
        $this->destService = new ResourcesDeliveriesRequestsDestinationsServices();
        $this->accountsServices = new ResourcesAccountsServices();
    }

    public function mount(): void
    {
        $response = $this->destService->ReadAll();
        $this->destinations = $response['data'] ?? $response;
    }

    public function addDriver($id, $name): void
    {
        // Update ke dalam formData
        if (!isset($this->formData['drivers'][$id])) {
            $this->formData['drivers'][$id] = $name;
        }
        $this->driverSearch = '';
    }

    public function removeDriver($id): void
    {
        // Hapus dari formData
        unset($this->formData['drivers'][$id]);
    }

    public function submit()
    {
        // Data siap digunakan untuk proses simpan
        $payload = [
            'destination_id' => $this->formData['destination'],
            'driver_ids' => array_keys($this->formData['drivers']),
        ];
    }

    public function getSelectedDestDetailProperty()
    {
        // Mencari detail destinasi berdasarkan ID yang ada di formData
        return collect($this->destinations)->firstWhere('id', $this->formData['destination']);
    }

    // Reset halaman ke 1 jika user mengganti destinasi
    // Di dalam class CreateForm
    public function updatedFormDataDestination($value)
    {
        if (!$value) return;

        // Cari data destinasi dari koleksi berdasarkan ID
        $destination = collect($this->destinations)->firstWhere('id', $value);

        if ($destination && isset($destination['receipt_address'])) {
            // Kirim event ke browser beserta alamatnya
            $this->dispatch('search-location', address: $destination['receipt_address']);
        }

        // Reset pagination tabel rincian
        $this->currentPage = 1;
    }

    // Reset halaman jika user mengganti jumlah per halaman
    public function updatedPerPage()
    {
        $this->currentPage = 1;
    }



    public function setPage($page)
    {
        $this->currentPage = $page;
    }

    public function render(): View
    {
        $suggestions = [];
        $searchTerm = trim($this->driverSearch);

        if (strlen($searchTerm) >= 1) {
            $response = $this->accountsServices->FindByName($searchTerm);

            if ($response['status'] && !empty($response['data'])) {
                $selectedIds = array_keys($this->formData['drivers']);
                $suggestions = collect($response['data'])
                    ->filter(fn($driver) => !in_array($driver['id'], $selectedIds))
                    ->values()
                    ->all();
            }
        }

        return view('dashboards.apps.deliveries.tasks.components.create-form', [
            'suggestions' => $suggestions,
            // Kirim detail destinasi ke blade melalui variabel
            'currentDest' => $this->selectedDestDetail
        ]);
    }
}
