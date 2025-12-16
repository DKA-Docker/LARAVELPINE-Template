<?php

namespace App\Services\Resources\Trackings\Monitors;

use App\Repositories\Apps\Trackings\Monitors\MonitorsRepository;
use Illuminate\Database\Eloquent\Collection;
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


    public function ReadAll(): Collection
    {
        return $this->repository
            ->query()
            ->selectRaw('DISTINCT ON (uuid) *')
            ->orderBy('uuid')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();
    }


}
