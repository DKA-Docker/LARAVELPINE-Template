<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Components;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Models\Data\Vehicles\DataVehicleCategories;
use App\Models\Data\Vehicles\DataVehicles;
use App\Services\Resources\Accounts\ResourcesAccountsServices;
use App\Services\Resources\Data\Geos\ResourcesDataGeosDistrictsServices;
use App\Services\Resources\Data\Geos\ResourcesDataGeosProvincesServices;
use App\Services\Resources\Data\Geos\ResourcesDataGeosRegenciesServices;
use App\Services\Resources\Data\Geos\ResourcesDataGeosVillagesServices;
use App\Services\Resources\Deliveries\Requests\Destinations\ResourcesDeliveriesRequestsDestinationsServices;
use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTasksServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;


#[Lazy]
class CreateForm extends Component
{
    // --- State Pagination & Search ---
    public $perPage = 5;
    public $currentPage = 1;
    public $driverSearch = '';

    public $formData = [
        'name' => '',
        'destination' => '',
        'assigned' => [],
        'geos' => [
            'latitude' => -6.2088,
            'longitude' => 106.8456,
            'province' => null,
            'regency' => null,
            'district' => null,
            'village' => null,
            'postal_code' => '',
        ],
        'first_name' => '',
        'vehicle_category' => '',
        'vehicle_id' => ''
    ];

    public $vehicleCategories = [];
    public $availableVehicles = [];

    public $destinations = [];
    public $provinces = [];
    public $regencies = [];
    public $districts = [];
    public $villages = [];

    protected ResourcesDeliveriesRequestsDestinationsServices $destService;
    protected ResourcesAccountsServices $accountsServices;
    protected ResourcesDataGeosProvincesServices $GeoProvincesServices;
    protected ResourcesDataGeosRegenciesServices $GeoRegenciesServices;
    protected ResourcesDataGeosDistrictsServices $GeoDistrictsServices;
    protected ResourcesDataGeosVillagesServices $GeoVillagesServices;
    protected ResourcesDeliveriesTasksServices $tasksServices;

    public function boot(): void
    {
        $this->destService = new ResourcesDeliveriesRequestsDestinationsServices();
        $this->accountsServices = new ResourcesAccountsServices();
        $this->GeoProvincesServices = new ResourcesDataGeosProvincesServices();
        $this->GeoRegenciesServices = new ResourcesDataGeosRegenciesServices();
        $this->GeoDistrictsServices = new ResourcesDataGeosDistrictsServices();
        $this->GeoVillagesServices = new ResourcesDataGeosVillagesServices();
        $this->tasksServices = new ResourcesDeliveriesTasksServices();
    }

    public function mount(): void
    {
        if (!Auth::user()->can('dashboards.apps.deliveries.tasks.create')) {
            throw new AuthorizationException("Unauthorized access to this scope.");
        }

        $response = $this->destService->ReadAll();
        $this->destinations = $response['data'] ?? $response;

        $resProv = $this->GeoProvincesServices->ReadAll();
        $this->provinces = $resProv['data'] ?? $resProv;

        $allCats = DataVehicleCategories::all();
        $this->vehicleCategories = $allCats->unique('name');
    }

    public function updatedFormDataVehicleCategory($value): void
    {
        $this->availableVehicles = [];
        $this->formData['vehicle_id'] = '';

        if ($value) {
            $this->availableVehicles = DataVehicles::whereHas('category', function ($q) use ($value) {
                $q->where('name', $value);
            })->get();
        }
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

            $this->formData['first_name'] = $dest['receipt_name'] ?? null;

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
        $this->validate([
            'formData.name' => 'required|string',
            'formData.destination' => 'required',
            'formData.geos.province' => 'required',
            'formData.geos.regency' => 'required',
            'formData.geos.district' => 'required',
            'formData.geos.village' => 'required',
            'formData.assigned' => 'required|array|min:1',
            'formData.vehicle_category' => 'required',
            'formData.vehicle_id' => 'required',
            'formData.geos.postal_code' => 'nullable',
        ], [
            'formData.assigned.required' => 'Minimal satu driver harus dipilih.',
            'formData.assigned.min' => 'Minimal satu driver harus dipilih.',
        ]);

        $response = $this->tasksServices->Create($this->formData);

        if ($response['status']) {
            // Flash ke session Laravel
            session()->flash('success', 'Delivery Task: ' . $this->formData['name'] . ' successfully created.');
            return redirect()->route('dashboards.apps.deliveries.tasks.index');
        } else {
            $this->addError('submit', $response['msg'] ?? 'An error occurred while creating the task.');
        }
    }

    public function getSelectedDestDetailProperty()
    {
        return collect($this->destinations)->firstWhere('id', $this->formData['destination']);
    }

    public function updatedPerPage(): void
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
            $response = $this->accountsServices->FindByName($searchTerm,"driver");
            if ($response['status'] && !empty($response['data'])) {
                $selectedIds = array_keys($this->formData['assigned']);
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
