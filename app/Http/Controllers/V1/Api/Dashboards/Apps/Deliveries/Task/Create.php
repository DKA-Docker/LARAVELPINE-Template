<?php
namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Task;

use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTaksServices;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;


class Create extends controller {

    protected ResourcesDeliveriesTaksServices $service;

    public function __construct(){
        $this->service = new ResourcesDeliveriesTaksServices();
    }

    public  function index()  {

        $data = $this->service->ReadAllRequest();
        return response()->json(
            data: array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => $data
            ),
            status: Response::HTTP_OK,
            headers: array(
                'Content-Type' => 'application/json'
            )
        );
    }
    public  function store(Request $request)  {
        $data =  $request->all();
        $results = $this->service->Create($data);
        if($results){
            return response()->json(
                data: array(
                    'status' => true,
                    'code' => Response::HTTP_OK,
                    'msg' => 'Successfully Creates Data',
                    'data' => $results,
                ),
                status: Response::HTTP_OK,
                headers: array(
                    'Content-Type' => 'application/json'
                )
            );
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
