<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Components;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Services\Resources\Accounts\ResourcesAccountsServices;
use App\Services\Resources\Data\Geos\ResourcesDataGeosDistrictsServices;
use App\Services\Resources\Data\Geos\ResourcesDataGeosProvincesServices;
use App\Services\Resources\Data\Geos\ResourcesDataGeosRegenciesServices;
use App\Services\Resources\Data\Geos\ResourcesDataGeosVillagesServices;
use App\Services\Resources\Deliveries\Requests\Destinations\ResourcesDeliveriesRequestsDestinationsServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class CreateForm extends Component
{
    public $perPage = 5;
    public $currentPage = 1;
    public $driverSearch = '';

    // FormData selaras dengan AppsDeliveriesTasks & AppsDeliveriesTasksGeos
    public $formData = [
        'name'        => '',
        'destination' => '',
        'assigned'    => [],
        'geos'        => [
            'latitude'    => -6.2088,
            'longitude'   => 106.8456,
            'province'    => null,
            'regency'     => null,
            'district'    => null,
            'village'     => null,
            'postal_code' => '',
        ],
    ];

    public $destinations = [];
    public $provinces = [];
    public $regencies = [];
    public $districts = [];
    public $villages  = [];

    protected ResourcesDeliveriesRequestsDestinationsServices $destService;
    protected ResourcesAccountsServices $accountsServices;
    protected ResourcesDataGeosProvincesServices $GeoProvincesServices;
    protected ResourcesDataGeosRegenciesServices $GeoRegenciesServices;
    protected ResourcesDataGeosDistrictsServices $GeoDistrictsServices;
    protected ResourcesDataGeosVillagesServices $GeoVillagesServices;

    public function boot(): void
    {
        $this->destService = new ResourcesDeliveriesRequestsDestinationsServices();
        $this->accountsServices = new ResourcesAccountsServices();
        $this->GeoProvincesServices = new ResourcesDataGeosProvincesServices();
        $this->GeoRegenciesServices = new ResourcesDataGeosRegenciesServices();
        $this->GeoDistrictsServices = new ResourcesDataGeosDistrictsServices();
        $this->GeoVillagesServices = new ResourcesDataGeosVillagesServices();
    }

    public function mount(): void
    {
        $response = $this->destService->ReadAll();
        $this->destinations = $response['data'] ?? $response;

        $resProv = $this->GeoProvincesServices->ReadAll();
        $this->provinces = $resProv['data'] ?? $resProv;
    }

    public function updatedFormDataDestination($value): void
    {
        if (!$value) {
            $this->resetGeo();
            return;
        }

        $dest = collect($this->destinations)->firstWhere('id', $value);

        if ($dest) {
            $this->formData['geos']['latitude'] = $dest['latitude'] ?? $this->formData['geos']['latitude'];
            $this->formData['geos']['longitude'] = $dest['longitude'] ?? $this->formData['geos']['longitude'];

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

            if (isset($dest['receipt_address'])) {
                $this->dispatch('search-location', address: $dest['receipt_address']);
            }
        }
        $this->currentPage = 1;
    }

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

    protected function loadRegencies($parentId): void {
        $res = $this->GeoRegenciesServices->ReadByIDParent($parentId);
        $this->regencies = $res['data'] ?? $res;
    }

    protected function loadDistricts($parentId): void {
        $res = $this->GeoDistrictsServices->ReadByIDParent($parentId);
        $this->districts = $res['data'] ?? $res;
    }

    protected function loadVillages($parentId): void {
        $res = $this->GeoVillagesServices->ReadByIDParent($parentId);
        $this->villages = $res['data'] ?? $res;
    }

    private function resetGeo() {
        $this->formData['geos']['province'] = $this->formData['geos']['regency'] = $this->formData['geos']['district'] = $this->formData['geos']['village'] = null;
        $this->regencies = $this->districts = $this->villages = [];
    }

    public function addDriver($id, $name): void
    {
        if (!isset($this->formData['assigned'][$id])) {
            $this->formData['assigned'][$id] = $name;
        }
        $this->driverSearch = '';
    }

    public function removeDriver($id): void
    {
        unset($this->formData['assigned'][$id]);
    }

    public function submit()
    {
        $data = $this->formData;
        Debugbar::log($data);
    }

    public function getSelectedDestDetailProperty()
    {
        return collect($this->destinations)->firstWhere('id', $this->formData['destination']);
    }

    public function updatedPerPage() { $this->currentPage = 1; }
    public function setPage($page) { $this->currentPage = $page; }

    public function render(): View
    {
        $suggestions = [];
        $searchTerm = trim($this->driverSearch);
        if (strlen($searchTerm) >= 1) {
            $response = $this->accountsServices->FindByName($searchTerm);
            if ($response['status'] && !empty($response['data'])) {
                $selectedIds = array_keys($this->formData['assigned']);
                $suggestions = collect($response['data'])->filter(fn($d) => !in_array($d['id'], $selectedIds))->values()->all();
            }
        }

        return view('dashboards.apps.deliveries.tasks.components.create-form', [
            'suggestions' => $suggestions,
            'currentDest' => $this->selectedDestDetail
        ]);
    }
}
