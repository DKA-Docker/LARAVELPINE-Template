<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Sessions;

use App\Models\Apps\Deliveries\Tasks\Sessions\AppsDeliveriesTasksSessions;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        $data = AppsDeliveriesTasksSessions::query()->withTrashed()
            ->select('*', DB::raw("ST_AsGeoJSON(route) as route_geojson"))
            ->with(['account.credential', 'task.destination', 'account.information'])
            ->find($this->sessionId);

        if ($data) {
            $this->sessionData = $data;
            $decodedGeo = json_decode($data->route_geojson, true);

            // Proses GeoJSON untuk List Log (Times & Speeds)
            $times = []; $speeds = [];
            if (isset($decodedGeo['coordinates'])) {
                $coords = $decodedGeo['coordinates'];
                $count = count($coords);
                
                for ($i = 0; $i < $count; $i++) {
                    $curr = $coords[$i];
                    
                    // 1. Time (M value at index 3)
                    $ts = isset($curr[3]) ? (float)$curr[3] : null;
                    if ($ts) {
                        $times[] = Carbon::createFromTimestamp($ts)->toIso8601String();
                    } else {
                        // Fallback time
                        $times[] = Carbon::parse($data->created_at)->addSeconds($i * 10)->toIso8601String();
                    }

                    // 2. Speed Calculation
                    $speedKmh = 0;
                    if ($i > 0) {
                        $prev = $coords[$i-1];
                        $t1 = isset($prev[3]) ? (float)$prev[3] : 0;
                        $t2 = isset($curr[3]) ? (float)$curr[3] : 0;
                        $deltaT = $t2 - $t1;
                        
                        // Haversine Distance
                        $lat1 = $prev[1]; $lon1 = $prev[0];
                        $lat2 = $curr[1]; $lon2 = $curr[0];
                        
                        $earthRadius = 6371000;
                        $dLat = deg2rad($lat2 - $lat1);
                        $dLon = deg2rad($lon2 - $lon1);
                        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
                        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
                        $distMeters = $earthRadius * $c;

                        if ($deltaT > 0) {
                             $speedMps = $distMeters / $deltaT;
                             $speedKmh = round($speedMps * 3.6);
                        }
                    }
                    $speeds[] = $speedKmh;
                }
            }

            $this->routeGeoJson = json_encode([
                'type' => 'Feature',
                'geometry' => $decodedGeo,
                'properties' => ['times' => $times, 'speeds' => $speeds]
            ]);

            // DESTINATION DATA (Penting untuk Jalur Merah)
            $this->destinationCoords = json_encode(['lat' => null, 'lng' => null, 'name' => 'Destination']);

            // FIX: Access relations safely using getRelation because column names conflict with relation names
            $task = $data->relationLoaded('task') ? $data->getRelation('task') : null;
            $dest = ($task && $task->relationLoaded('destination')) ? $task->getRelation('destination') : null;

            if ($dest && $dest->coordinate_latitude && $dest->coordinate_longitude) {
                $name = $dest->receipt_name;
                if (!$name && $dest->account) {
                    $name = $dest->account->information->first_name ?? $dest->account->username ?? null;
                }

                $this->destinationCoords = json_encode([
                    'lat' => (float)$dest->coordinate_latitude,
                    'lng' => (float)$dest->coordinate_longitude,
                    'name' => $name ?: 'TUJUAN'
                ]);
            }

            $this->dispatch('update-session-map');
        }
    }

    public function render()
    {
        return view('dashboards.apps.deliveries.tasks.sessions.detail-component');
    }
}
