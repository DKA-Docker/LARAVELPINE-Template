<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks;

use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTaksServices;
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

    protected ResourcesDeliveriesTaksServices $service;

    public function __construct(){
        $this->service = new ResourcesDeliveriesTaksServices();
    }

    public function index()
    {
        $pass = array(
            'url_create' => route(Route::currentRouteName()),
        );

        return view('dashboards.apps.deliveries.tasks.create', $pass);
    }

    /**
     * @throws ConnectionException
     */
    public function store(Request $request)
    {
        $data =  $request->all();
        $results = $this->service->Create($data);
//        return $data;
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
}

