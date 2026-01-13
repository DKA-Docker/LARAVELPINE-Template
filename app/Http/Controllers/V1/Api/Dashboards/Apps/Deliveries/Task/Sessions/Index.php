<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Task\Sessions;

use Illuminate\Routing\Controller;
use App\Services\Resources\Deliveries\Tasks\Sessions\TasksSessionsServices;
use Illuminate\Http\Request;

class Index extends Controller
{
    protected TasksSessionsServices $service;

    public function __construct()
    {
        $this->service = new TasksSessionsServices();
    }

    public function index(Request $request)
    {
        return response()->json($this->service->ReadAll());
    }

    public function store(Request $request)
    {
        $result = $this->service->Create($request->all());
        return response()->json($result, $result['code']);
    }

    public function show($id)
    {
        return response()->json($this->service->Find($id));
    }

    public function update(Request $request, $id)
    {
        $result = $this->service->Update($id, $request->all());
        return response()->json($result, $result['code']);
    }

    public function destroy($id)
    {
        $result = $this->service->Delete($id);
        return response()->json($result, $result['code']);
    }
}
