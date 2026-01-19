<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Sessions;

use App\Models\Apps\Deliveries\Tasks\Sessions\AppsDeliveriesTasksSessions;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Detail extends Component
{
    public $sessionId;
    public $sessionData;
    public $routeGeoJson;
    public $destinationCoords;

    public function mount($sessionId)
    {
        $this->sessionId = $sessionId;
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->sessionData = AppsDeliveriesTasksSessions::query()
            ->select('*', \Illuminate\Support\Facades\DB::raw("ST_AsGeoJSON(route) as route_geojson"))
            ->with(['accountDetail.credential', 'taskDetail.destination', 'accountDetail.information'])
            ->find($this->sessionId);

        if ($this->sessionData) {
            $this->routeGeoJson = $this->sessionData->route_geojson;
            
            // Destination metadata
            $this->destinationCoords = json_encode(['lat' => null, 'lng' => null, 'name' => 'Destination']);
            
            if ($this->sessionData->taskDetail) {
                // Use relationship method to avoid conflict with 'destination' column name
                $dest = $this->sessionData->taskDetail->destination()->first();
                
                if ($dest && $dest->coordinate_latitude && $dest->coordinate_longitude) {
                    $this->destinationCoords = json_encode([
                        'lat' => (float)$dest->coordinate_latitude,
                        'lng' => (float)$dest->coordinate_longitude,
                        'name' => $dest->receipt_name ?: 'Destination'
                    ]);
                }
            }

            // Dispatch update to JS
            $this->dispatch('update-session-map');
        }
    }

    public function render()
    {
        return view('dashboards.apps.deliveries.tasks.sessions.detail-component');
    }
}
