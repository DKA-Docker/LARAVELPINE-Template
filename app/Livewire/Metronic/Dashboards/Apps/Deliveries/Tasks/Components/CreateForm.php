<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Components;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Services\Resources\Accounts\ResourcesAccountsServices;
use App\Services\Resources\Data\Geos\ResourcesDataGeosDistrictsServices;
use App\Services\Resources\Data\Geos\ResourcesDataGeosProvincesServices;
use App\Services\Resources\Data\Geos\ResourcesDataGeosRegenciesServices;
use App\Services\Resources\Data\Geos\ResourcesDataGeosVillagesServices;
use App\Services\Resources\Deliveries\Requests\Destinations\ResourcesDeliveriesRequestsDestinationsServices;
use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTaksServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

/**
 * CreateForm Component
 * * Komponen ini menangani pembuatan tugas pengiriman (Delivery Tasks).
 * Fitur Utama:
 * 1. Manajemen Form Data (Nama, Destinasi, Driver)
 * 2. Sinkronisasi Geografis bertingkat (Provinsi -> Kota -> Kecamatan -> Desa)
 * 3. Pencarian Driver secara Real-time
 * 4. Integrasi dengan Peta (via Dispatch Event)
 */
class CreateForm extends Component
{
    // --- State Pagination & Search ---
    public $perPage = 5;
    public $currentPage = 1;
    public $driverSearch = ''; // Input pencarian untuk driver (assigned)

    /**
     * Objek Utama Data Form
     * Struktur ini disesuaikan untuk model AppsDeliveriesTasks & AppsDeliveriesTasksGeos
     */
    public $formData = [
        'name' => '',
        'destination' => '',
        'assigned' => [], // Daftar driver yang dipilih [id => name]
        'geos' => [
            'latitude' => -6.2088,
            'longitude' => 106.8456,
            'province' => null,
            'regency' => null,
            'district' => null,
            'village' => null,
            'postal_code' => '',
        ],
    ];

    // --- Data Dropdown (Lists) ---
    public $destinations = [];
    public $provinces = [];
    public $regencies = [];
    public $districts = [];
    public $villages = [];

    // --- Services ---
    protected ResourcesDeliveriesRequestsDestinationsServices $destService;
    protected ResourcesAccountsServices $accountsServices;
    protected ResourcesDataGeosProvincesServices $GeoProvincesServices;
    protected ResourcesDataGeosRegenciesServices $GeoRegenciesServices;
    protected ResourcesDataGeosDistrictsServices $GeoDistrictsServices;
    protected ResourcesDataGeosVillagesServices $GeoVillagesServices;

    protected ResourcesDeliveriesTaksServices $taksServices;

    /**
     * Inisialisasi Service melalui Lifecycle Boot
     * Dijalankan pada setiap request (initial load & update)
     */
    public function boot(): void
    {
        $this->destService = new ResourcesDeliveriesRequestsDestinationsServices();
        $this->accountsServices = new ResourcesAccountsServices();
        $this->GeoProvincesServices = new ResourcesDataGeosProvincesServices();
        $this->GeoRegenciesServices = new ResourcesDataGeosRegenciesServices();
        $this->GeoDistrictsServices = new ResourcesDataGeosDistrictsServices();
        $this->GeoVillagesServices = new ResourcesDataGeosVillagesServices();

        $this->taksServices = new ResourcesDeliveriesTaksServices();
    }

    /**
     * Initial Load
     * Mengambil data awal untuk dropdown Destinasi dan Provinsi
     */
    public function mount(): void
    {
        $response = $this->destService->ReadAll();
        $this->destinations = $response['data'] ?? $response;

        $resProv = $this->GeoProvincesServices->ReadAll();
        $this->provinces = $resProv['data'] ?? $resProv;
    }

    /**
     * Lifecycle Hook: Triggered saat destinasi dipilih
     * Otomatis mengisi data koordinat dan hierarki wilayah berdasarkan data destinasi
     */
    public function updatedFormDataDestination($value): void
    {
        if (!$value) {
            $this->resetGeo();
            return;
        }

        $dest = collect($this->destinations)->firstWhere('id', $value);

        if ($dest) {
            // Update Koordinat
            $this->formData['geos']['latitude'] = $dest['latitude'] ?? $this->formData['geos']['latitude'];
            $this->formData['geos']['longitude'] = $dest['longitude'] ?? $this->formData['geos']['longitude'];

            // Sinkronisasi Wilayah (Cascading Load)
            $this->formData['geos']['province'] = $dest['province_id'] ?? $dest['province'] ?? null;
            if ($this->formData['geos']['province']) {
                $this->loadRegencies($this->formData['geos']['province']);
                $this->formData['geos']['regency'] = $dest['regency_id'] ?? $dest['regency'] ?? null;

                if ($this->formData['geos']['regency']) {
                    $this->loadDistricts($this->formData['geos']['regency']);
                    $this->formData['geos']['district'] = $dest['district_id'] ?? $dest['district'] ?? null;

                    if ($this->formData['geos']['district']) {
                        $this->loadVillages($this->formData['geos']['district']);
                        $this->formData['geos']['village'] = $dest['village_id'] ?? $dest['village'] ?? null;
                    }
                }
            }

            // Memberitahu Frontend (JS/Maps) untuk mencari lokasi berdasarkan alamat
            if (isset($dest['receipt_address'])) {
                $this->dispatch('search-location', address: $dest['receipt_address']);
            }
        }
        $this->currentPage = 1;
    }

    // --- Wilayah Updated Hooks (Reset level di bawahnya saat level atas berubah) ---

    public function updatedFormDataGeosProvince($value): void
    {
        $this->loadRegencies($value);
        $this->formData['geos']['regency'] = $this->formData['geos']['district'] = $this->formData['geos']['village'] = null;
        $this->districts = $this->villages = [];
    }

    public function updatedFormDataGeosRegency($value)
    {
        $this->loadDistricts($value);
        $this->formData['geos']['district'] = $this->formData['geos']['village'] = null;
        $this->villages = [];
    }

    public function updatedFormDataGeosDistrict($value)
    {
        $this->loadVillages($value);
        $this->formData['geos']['village'] = null;
    }

    // --- Geo Data Fetchers ---

    protected function loadRegencies($parentId): void
    {
        $res = $this->GeoRegenciesServices->ReadByIDParent($parentId);
        $this->regencies = $res['data'] ?? $res;
    }

    protected function loadDistricts($parentId): void
    {
        $res = $this->GeoDistrictsServices->ReadByIDParent($parentId);
        $this->districts = $res['data'] ?? $res;
    }

    protected function loadVillages($parentId): void
    {
        $res = $this->GeoVillagesServices->ReadByIDParent($parentId);
        $this->villages = $res['data'] ?? $res;
    }

    private function resetGeo(): void
    {
        $this->formData['geos']['province'] = $this->formData['geos']['regency'] = $this->formData['geos']['district'] = $this->formData['geos']['village'] = null;
        $this->regencies = $this->districts = $this->villages = [];
    }

    // --- Driver Assignment Logic ---

    /** Menambahkan driver terpilih ke array assigned */
    public function addDriver($id, $name): void
    {
        if (!isset($this->formData['assigned'][$id])) {
            $this->formData['assigned'][$id] = $name;
        }
        $this->driverSearch = ''; // Reset input pencarian setelah dipilih
    }

    /** Menghapus driver dari array assigned */
    public function removeDriver($id): void
    {
        unset($this->formData['assigned'][$id]);
    }

    /** Final Submit Task */
    public function submit(): void
    {
        $data = $this->formData;
        Debugbar::log($data); // Debugging data sebelum diproses model
    }

    /** Computed Property: Mendapatkan detail objek destinasi yang sedang dipilih */
    public function getSelectedDestDetailProperty()
    {
        return collect($this->destinations)->firstWhere('id', $this->formData['destination']);
    }

    // --- Pagination Actions ---

    public function updatedPerPage(): void
    {
        $this->currentPage = 1;
    }

    public function setPage($page)
    {
        $this->currentPage = $page;
    }

    /**
     * Render View
     * Menangani logika pencarian driver (suggestions) saat user mengetik
     */
    public function render(): View
    {
        $suggestions = [];
        $searchTerm = trim($this->driverSearch);

        // Cari driver hanya jika input >= 1 karakter
        if (strlen($searchTerm) >= 1) {
            $response = $this->accountsServices->FindByName($searchTerm);
            if ($response['status'] && !empty($response['data'])) {
                $selectedIds = array_keys($this->formData['assigned']);
                // Filter agar driver yang sudah dipilih tidak muncul kembali di saran
                $suggestions = collect($response['data'])
                    ->filter(fn($d) => !in_array($d['id'], $selectedIds))
                    ->values()
                    ->all();
            }
        }

        return view('dashboards.apps.deliveries.tasks.components.create-form', [
            'suggestions' => $suggestions,
            'currentDest' => $this->selectedDestDetail
        ]);
    }
}
