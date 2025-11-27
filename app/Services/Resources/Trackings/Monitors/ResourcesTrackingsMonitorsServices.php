<?php

namespace App\Services\Resources\Trackings\Monitors;

use App\Repositories\Apps\Trackings\Monitors\MonitorsRepository;
use Illuminate\Http\Request;

class ResourcesTrackingsMonitorsServices
{

    protected MonitorsRepository $repository;

    public function __construct(){
        $this->repository = new MonitorsRepository();
    }

    public function Create(Request $request) {
        $allRequest = $request->all();
        return $this->repository->create($allRequest);
    }
}
