<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks;

use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTasksServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class Create extends Controller
{

    protected ResourcesDeliveriesTasksServices $service;

    public function __construct(){
        $this->service = new ResourcesDeliveriesTasksServices();
    }

    public function index()
    {
        $pass = array(
            'url_create' => route(Route::currentRouteName()),
        );

        return view('dashboards.apps.deliveries.tasks.create', $pass);
    }

    /**
     */
    public function store(Request $request)
    {
        $data =  $request->all();
        $results = $this->service->Create($data);
        if($results){
            return redirect()->route(implode('.', array_slice(explode('.', Route::currentRouteName()), 0, -2)).'.index')->with('success', 'Berhasil di Tambahkan');
        }else{
            return response()->json(
                data: array(
                    'status' => false,
                    'code' => Response::HTTP_UNAUTHORIZED,
                    'msg' => 'Failed Read Data',
                    'data' => $data,
                ),
                status: Response::HTTP_UNAUTHORIZED,
                headers: array(
                    'Content-Type' => 'application/json'
                )
            );
        }


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

