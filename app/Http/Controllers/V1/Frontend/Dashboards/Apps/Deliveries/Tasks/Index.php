<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTasksServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Index extends Controller
{
    protected ResourcesDeliveriesTasksServices $service;

    public function __construct(ResourcesDeliveriesTasksServices $service)
    {
        $this->service = $service;
    }

    public function index(): Factory|View
    {
        return view('dashboards.apps.deliveries.tasks.index');
    }

    public function show($id)
    {
        $task = $this->service->Find($id);

        if (!$task) {
            abort(404);
        }

        // Eager load relationships needed for the tabs
        $task->load(['assigned.information', 'geos', 'history', 'destination', 'vehicle']);

        return view('dashboards.apps.deliveries.tasks.detail-page', compact('task'));
    }

    public function destroy($id): JsonResponse
    {
        $response = $this->service->Delete($id);
        return response()->json($response, $response['code']);
    }
}
