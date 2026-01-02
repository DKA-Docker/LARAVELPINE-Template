<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Requests;


use App\Services\Resources\Deliveries\Requests\ResourcesDeliveriesRequestsServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class Create extends Controller
{
    protected ResourcesDeliveriesRequestsServices $services;
    public function __construct()
    {
        $this->services = new ResourcesDeliveriesRequestsServices();
    }

    public function index(): Factory|View
    {

        return view('dashboards.apps.deliveries.requests.create');
//        return view('dashboards.apps.deliveries.requests.create');
    }

    /**
     * @throws ConnectionException
     */
    public function GeocodingProxy(Request $request)
    {
        $query = $request->query('q');

        // Nominatim mewajibkan User-Agent yang jelas
        $response = Http::withHeaders([
            'User-Agent' => config('app.name') . ' - Geocoding System'
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $query,
            'format' => 'json',
            'addressdetails' => 1,
            'limit' => 6,
            'countrycodes' => 'id',
        ]);

        return response()->json($response->json(), $response->status());
    }

}
