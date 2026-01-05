<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Task\Attachments;

use App\Services\Resources\Deliveries\Tasks\Attachments\ResourcesDeliveriesTasksAttachmentsServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Index extends Controller
{
    protected ResourcesDeliveriesTasksAttachmentsServices $service;

    public function __construct()
    {
        $this->service = new ResourcesDeliveriesTasksAttachmentsServices();
    }

    /**
     * Store a newly created attachment in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'task_id' => 'required|exists:apps_deliveries_tasks,id',
            'file' => 'required|file|max:10240', // Max 10MB
        ]);

        $result = $this->service->Store($request);

        return response()->json($result, $result['code']);
    }

    /**
     * Remove the specified attachment from storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $result = $this->service->Delete($id);

        return response()->json($result, $result['code']);
    }
}
