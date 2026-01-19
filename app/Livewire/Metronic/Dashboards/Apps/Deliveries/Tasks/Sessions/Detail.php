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
                $count = count($decodedGeo['coordinates']);
                $startTime = \Carbon\Carbon::parse($data->created_at);
                for ($i = 0; $i < $count; $i++) {
                    $times[] = $startTime->copy()->addSeconds($i * 10)->toIso8601String();
                    $speeds[] = rand(20, 60); // Ganti dengan data asli jika ada
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
