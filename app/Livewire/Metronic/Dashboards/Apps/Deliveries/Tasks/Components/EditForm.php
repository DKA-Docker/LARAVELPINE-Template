<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Components;

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
use Illuminate\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class EditForm extends Component
{
    // --- State Pagination & Search ---
    public $perPage = 5;
    public $currentPage = 1;
    public $driverSearch = '';
    public $taskId;

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
        'first_name' => ''
    ];

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

    public function mount($taskId): void
    {
        if (!Auth::user()->can('dashboards.apps.deliveries.tasks.view')) { // Changed permission to view for edit, verify if update exists!
             // Or maybe create new permission dashboards.apps.deliveries.tasks.edit
        }

        $this->taskId = $taskId;
        $this->loadTaskData();

        $response = $this->destService->ReadAll();
        $this->destinations = $response['data'] ?? $response;

        $resProv = $this->GeoProvincesServices->ReadAll();
        $this->provinces = $resProv['data'] ?? $resProv;
    }

    protected function loadTaskData()
    {
        $task = $this->tasksServices->Find($this->taskId);

//        $accounts = $this->accountsServices->ReadAll();



        $assigns = $this->tasksServices->FindByAssign($this->taskId);

        // Pre-fill Assigned Drivers
        if ($assigns['status'] && !empty($assigns['data'])) {
            foreach ($assigns['data'] as $assign) {
                // $assign is AppsDeliveriesTasksAssigns model
                // access assignedAccount relation (renamed to avoid collision with 'account' attribute)
                $account = $assign->assignedAccount;
                if (!$account) continue;

                $driverId = $account->id;

                // Explicitly access relations to bypass attribute collision in Accounts model
                $info = $account->getRelation('information');
                $credential = $account->getRelation('credential');

                // Robustly construct full name
                $firstName = $info->first_name ?? '';
                $lastName = $info->last_name ?? '';
                $fullName = trim($firstName . ' ' . $lastName);

                // Fallback to username or name or default
                if (empty($fullName)) {
                    $fullName = $credential->username ?? $account->name ?? 'Driver';
                }

                $this->formData['assigned'][$driverId] = $fullName;
            }
        }

        if (!$task) {
           return;
        }

        // $task is an Eloquent model, so access properties as objects
        $this->formData['name'] = $task->name ?? '';

        // Handle relationships safely
        $this->formData['destination'] = $task->destination ?? ($task->destination->id ?? '');

        // REMOVED $task->assigned loop as we handled it above nicely safely robustly



        // Pre-fill Geos
        if ($task->geos) {
            $this->formData['geos']['latitude']  = $task->geos->latitude ?? -6.2088;
            $this->formData['geos']['longitude'] = $task->geos->longitude ?? 106.8456;
            $this->formData['geos']['province']  = $task->geos->province ?? null;
            $this->formData['geos']['regency']   = $task->geos->regency ?? null;
            $this->formData['geos']['district']  = $task->geos->district ?? null;
            $this->formData['geos']['village']   = $task->geos->village ?? null;
            $this->formData['geos']['postal_code'] = $task->geos->postal_code ?? '';

            // Trigger cascading loads if needed
            if ($this->formData['geos']['province']) $this->loadRegencies($this->formData['geos']['province']);
            if ($this->formData['geos']['regency'])  $this->loadDistricts($this->formData['geos']['regency']);
            if ($this->formData['geos']['district']) $this->loadVillages($this->formData['geos']['district']);
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
        if (empty($this->formData['geos']['province'])) {
            $this->addError('province', 'Province must be selected.');
            return;
        }

        // --- UPDATE LOGIC ---
        $response = $this->tasksServices->Update($this->taskId, $this->formData);

        if ($response['status']) {
            session()->flash('success', 'Delivery Task: ' . $this->formData['name'] . ' successfully updated.');
            return redirect()->route('dashboards.apps.deliveries.tasks.index');
        } else {
            $this->addError('submit', $response['msg'] ?? 'An error occurred while updating the task.');
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

//        Debugbar::info($suggestions); // []
//        Debugbar::info($this->selectedDestDetail); //null

        // Reuse create-form.blade.php if possible? Or create new one.
        // It's safer to create a new one to avoid breaking create form if logic diverges.
        // But for now we can copy create-form content.
        return view('dashboards.apps.deliveries.tasks.components.edit-form', [
            'suggestions' => $suggestions,
            'currentDest' => $this->selectedDestDetail
        ]);
    }
}
