<?php

namespace App\Livewire\Metronic\Dashboards\Settings\Vehicles\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class View extends Component
{
    public $activeTab = 'vehicles';

    public function mount()
    {
        // Set default tab or from query string
        $this->activeTab = request()->query('tab', 'vehicles');
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public $confirmingDeletion = false;
    public $deleteId = null;
    public $deleteType = null; // 'vehicle' or 'category'

    #[On('confirm-delete')]
    public function confirmDelete($id, $type)
    {
        $this->deleteId = $id;
        $this->deleteType = $type;
        $this->confirmingDeletion = true;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->deleteId = null;
        $this->deleteType = null;
    }

    public function deleteConfirmed(
        \App\Services\Resources\Data\Vehicles\DataVehiclesServices $vehicleService,
        \App\Services\Resources\Data\Vehicles\DataVehicleCategoriesServices $categoryService
    ) {
        if ($this->deleteId && $this->deleteType) {
            try {
                $response = null;

                if ($this->deleteType === 'vehicle') {
                    $response = $vehicleService->Delete($this->deleteId);
                } elseif ($this->deleteType === 'category') {
                    $response = $categoryService->Delete($this->deleteId);
                }

                if ($response && $response['status']) {
                    session()->flash('success', ucfirst($this->deleteType) . ' deleted successfully.');
                    // Refresh the appropriate child component
                    $this->dispatch('refresh-list'); 
                } else {
                    session()->flash('error', 'Failed to delete ' . $this->deleteType . ': ' . ($response['msg'] ?? 'Unknown error'));
                }
            } catch (\Exception $e) {
                session()->flash('error', 'Error: ' . $e->getMessage());
            }

            $this->confirmingDeletion = false;
            $this->deleteId = null;
            $this->deleteType = null;
        }
    }

    public function render()
    {
        return view('dashboards.settings.vehicles.components.view');
    }
}
