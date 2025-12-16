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
        $driver = config('database.default'); // ambil driver saat ini

        if ($driver === 'pgsql') {
            // PostgreSQL: DISTINCT ON bisa dipakai langsung
            return $this->repository
                ->query()
                ->selectRaw('DISTINCT ON (uuid) *')
                ->orderBy('uuid')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get();
        }

        // MariaDB/MySQL: gunakan subquery
        return $this->repository
            ->query()
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('your_table_name') // ganti sesuai tabel repo
                    ->groupBy('uuid');
            })
            ->orderBy('uuid')
            ->orderByDesc('created_at')
            ->get();
    }


}
