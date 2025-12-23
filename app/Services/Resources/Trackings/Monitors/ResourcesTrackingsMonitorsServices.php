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

    public function Create(array $request) {
        return $this->repository->create($request);
    }


    public function ReadAll(): Collection
    {
        $driver = config('database.default'); // ambil driver saat ini

        // PostgreSQL: DISTINCT ON bisa dipakai langsung
        return $this->repository
            ->query()
            ->selectRaw('DISTINCT ON (account) *')
            ->orderBy('account')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();
    }


}
