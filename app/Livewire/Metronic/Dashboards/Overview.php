<?php

namespace App\Livewire\Metronic\Dashboards;

use Livewire\Component;
use Livewire\Attributes\Lazy;
use App\Services\Dashboards\Overview\DashboardOverviewDemographyService;

#[Lazy]
class Overview extends Component
{
    public $selectedProvince = null;
    public $selectedRegency = null;
    public $selectedDistrict = null;
    public $selectedVillage = null;

    public $provinces = [];
    public $regencies = [];
    public $districts = [];
    public $villages = [];

    protected DashboardOverviewDemographyService $demographyService;

    public function boot(DashboardOverviewDemographyService $demographyService)
    {
        $this->demographyService = $demographyService;
    }

    public function mount()
    {
        $this->provinces = $this->demographyService->getProvinces();
    }

    public function updatedSelectedProvince($value)
    {
        $this->selectedRegency = null;
        $this->selectedDistrict = null;
        $this->selectedVillage = null;
        $this->regencies = $value ? $this->demographyService->getRegencies($value) : [];
        $this->districts = [];
        $this->villages = [];
        $this->updateChart();
    }

    public function updatedSelectedRegency($value)
    {
        $this->selectedDistrict = null;
        $this->selectedVillage = null;
        $this->districts = $value ? $this->demographyService->getDistricts($value) : [];
        $this->villages = [];
        $this->updateChart();
    }

    public function updatedSelectedDistrict($value)
    {
        $this->selectedVillage = null;
        $this->villages = $value ? $this->demographyService->getVillages($value) : [];
        $this->updateChart();
    }
    
    public function updatedSelectedVillage($value)
    {
        $this->updateChart();
    }

    public function updateChart()
    {
        $filters = [
            'province_id' => $this->selectedProvince,
            'regency_id' => $this->selectedRegency,
            'district_id' => $this->selectedDistrict,
            'village_id' => $this->selectedVillage,
        ];

        $data = $this->demographyService->getDemographics($filters);
        $this->dispatch('overview-update-chart', data: $data);
    }

    public function placeholder()
    {
        return view('dashboards.components.overview-skeleton');
    }

    public function render()
    {
        // Initial load or re-render
        $filters = [
            'province_id' => $this->selectedProvince,
            'regency_id' => $this->selectedRegency,
            'district_id' => $this->selectedDistrict,
            'village_id' => $this->selectedVillage,
        ];
        
        $demographics = $this->demographyService->getDemographics($filters);
        
        return view('dashboards.components.overview', compact('demographics'));
    }
}
