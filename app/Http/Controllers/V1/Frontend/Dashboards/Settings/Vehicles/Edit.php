<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Settings\Vehicles;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use App\Models\Data\Vehicles\DataVehicles;
use App\Services\Resources\Data\Vehicles\DataVehiclesServices;
use Illuminate\Http\Request;

class Edit extends Controller
{
    public function index(Request $request, $id)
    {
        // Use Service to find vehicle
        $service = new DataVehiclesServices();
        $vehicle = $service->Find($id);
        
        return view('dashboards.settings.vehicles.edit', [
            'vehicle' => $vehicle
        ]);
    }
}
