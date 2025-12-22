<?php

namespace App\Services\Resources\Deliveries\Tasks\Geos;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasksAssigns;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasksGeos;
use App\Repositories\Apps\Deliveries\Tasks\Geos\TasksGeosRepository;
use App\Repositories\Apps\Deliveries\Tasks\TasksRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResourcesDeliveriesTasksGeosService
{
    protected TasksGeosRepository $repository;

    public function __construct()
    {
        $this->repository = new TasksGeosRepository();
    }

    /**
     * @throws \Throwable
     */
    public function Create(...$args): AppsDeliveriesTasksGeos
    {
        // 1. Ambil ID User yang sedang login (Pembuat Task)
        $currentUserId = Auth::id();

        // 2. Ambil List Driver dari inputan (sebelum kita timpa)
        // Ini adalah array [id_driver_1, id_driver_2] dari form multi-select
        $driverList = $args[0]['account'] ?? [];

        // 3. MANIPULASI $args untuk Repository (Main Task)
        // Repository butuh 'account' sebagai ID Pembuat, bukan Array Driver.
        // Jadi kita timpa index 'account' di dalam $args.
        if (isset($args[0])) {
            $args[0]['account'] = $currentUserId;
        }
        DB::beginTransaction();

        // 4. Simpan Main Task (Sekarang 'account' isinya $currentUserId)
        $taskCreated = $this->repository->Create(...$args);

        // 5. Simpan Data Assign (Looping Driver yang tadi kita simpan di $driverList)
        if ($taskCreated && !empty($driverList) && is_array($driverList)) {

            foreach ($driverList as $driverId) {
                AppsDeliveriesTasksAssigns::create([
                    'task'    => $taskCreated->id, // ID Task baru
                    'account' => $driverId,        // ID Driver dari inputan asli
                ]);
            }
        }
        DB::commit();
        return $taskCreated;

    }


    public function query(): Builder
    {
        return $this->repository->query();
    }
    public function ReadAll(): Collection
    {
        return $this->repository->ReadAll();
    }

    public function AutomaticallyPaginationTable(Request $request): Collection
    {
        $query = $this->repository
            ->query()
            ->when(
                $request->filled('assigned'),
                fn($q) => $q->whereHas(
                    'assigned',
                    fn($a) => $a->where('accounts.id', $request->get('assigned'))
                )
            )
            ->when(
                $request->filled('status'),
                fn($q) => $q->whereHas(
                    'history',
                    fn($h) => $h->where('to_status', $request->get('status'))
                )
            )
            ->orderByDesc('created_at');

        if (!$request->hasAny(['page', 'size'])) {
            return $query->get();
        }

        $page = max((int)$request->get('page', 1), 1);
        $size = (int)$request->get('size');

        if ($size > 0) {
            $query->skip(($page - 1) * $size)->take($size);
        }

        return $query->get();
    }


    public function Count(): int
    {
        return $this->repository->Count();
    }

    public function Find($id)
    {
        return $this->repository->Find($id);
    }
}
