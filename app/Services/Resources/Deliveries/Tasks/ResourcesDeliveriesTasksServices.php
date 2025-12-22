<?php

namespace App\Services\Resources\Deliveries\Tasks;

use App\Helpers\Exceptions\HelpersExceptionsHttpCode;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Repositories\Apps\Deliveries\Tasks\Assigns\TasksAssignsRepository;
use App\Repositories\Apps\Deliveries\Tasks\TasksRepository;
use App\Services\Resources\Deliveries\Tasks\Geos\ResourcesDeliveriesTasksGeosService;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class ResourcesDeliveriesTasksServices
{
    protected TasksRepository $repository;
    protected ResourcesDeliveriesTasksGeosService $geos;
    protected TasksAssignsRepository $assigns;
    protected HelpersExceptionsHttpCode $HelpersExceptionsHttpCode;

    public function __construct()
    {
        $this->repository = new TasksRepository();
        $this->geos = new ResourcesDeliveriesTasksGeosService();
        $this->assigns = new TasksAssignsRepository();
        $this->HelpersExceptionsHttpCode = new HelpersExceptionsHttpCode();
    }

    /**
     * Creates Delivery Task (atomik) + afterCommit
     * @return array{status:bool,code:int,msg:string,data?:mixed}
     * @throws Throwable
     */
    public function Create(array $payload): array
    {
//        DB::beginTransaction();
        try {
            // 1. Ambil ID User login sebagai pembuat task
            $currentUserId = Auth::id();

            // 2. Ambil List Driver dari inputan 'assigned' (format array keys dari Livewire)
            $driverIds = isset($payload['assigned']) ? array_keys($payload['assigned']) : [];

            // 3. Persiapkan data untuk Repository Utama
            $taskData = $payload;
            $taskData['account'] = $currentUserId;

            // 4. Simpan Main Task
            $taskCreated = $this->repository->Create($taskData);
            Debugbar::error($taskCreated);

            // 5. Simpan Data Assign menggunakan Repository $this->assigns
            if ($taskCreated && !empty($driverIds)) {
                foreach ($driverIds as $driverId) {
                    $this->assigns->Create([
                        'task'    => $taskCreated->id,
                        'account' => $driverId,
                    ]);
                }
            }

            // 6. Simpan Geos dengan memastikan seluruh field wilayah terkirim
            if ($taskCreated && isset($payload['geos'])) {
                $geosPayload = $payload['geos'];
                $geosPayload['task'] = $taskCreated->id;

                if (!isset($geosPayload['province'])) {
                    Debugbar::error("Missing province data in geos payload", $geosPayload);
                }

                $this->geos->Create($geosPayload);
            }

//            DB::afterCommit(function () use ($taskCreated) {
//                // Side effects: Notifikasi, Log, dll
//            });

//            DB::commit();

            return [
                'status' => true,
                'code'   => 201,
                'msg'    => 'Delivery Task Successfully Created',
                'data'   => $taskCreated->load(['assigned', 'geos']),
            ];

        } catch (QueryException $e) {
            Debugbar::warning($e);
            DB::rollBack();
            return $this->HelpersExceptionsHttpCode->fromSQLError($e);
        } catch (Throwable $e) {
            Debugbar::error($e);
            DB::rollBack();
            return [
                'status' => false,
                'code'   => 500,
                'msg'    => 'Unexpected error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update Delivery Task (atomik)
     */
    public function Update(string $id, array $payload): array
    {
        DB::beginTransaction();
        try {
            /** @var AppsDeliveriesTasks|null $task */
            $task = $this->repository->Find($id);

            if (!$task) {
                DB::rollBack();
                return [
                    'status' => false,
                    'code'   => 404,
                    'msg'    => 'Delivery Task not found',
                ];
            }

            // 1. Update Main Task Data
            $this->repository->Update($task, $payload);

            // 2. Sync Drivers menggunakan Repository $this->assigns
            if (isset($payload['assigned'])) {
                $driverIds = array_keys($payload['assigned']);

                // Menghapus assign lama melalui query builder dari repository
                $this->assigns->query()->where('task', $task->id)->delete();

                foreach ($driverIds as $driverId) {
                    $this->assigns->Create([
                        'task'    => $task->id,
                        'account' => $driverId,
                    ]);
                }
            }

            // 3. Update Geos
            if (isset($payload['geos'])) {
                $this->geos->Update($task->geos, $payload['geos']);
            }

            DB::commit();

            return [
                'status' => true,
                'code'   => Response::HTTP_OK,
                'msg'    => 'Delivery Task Successfully Updated',
                'data'   => $task->load(['assigned', 'geos']),
            ];

        } catch (QueryException $e) {
            DB::rollBack();
            return $this->HelpersExceptionsHttpCode->fromSQLError($e);
        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code'   => 500,
                'msg'    => 'Unexpected error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Delete Delivery Task
     */
    public function Delete(string $id): array
    {
        DB::beginTransaction();
        try {
            /** @var AppsDeliveriesTasks|null $task */
            $task = $this->repository->Find($id);

            if (!$task) {
                DB::rollBack();
                return [
                    'status' => false,
                    'code'   => 404,
                    'msg'    => 'Delivery Task not found',
                ];
            }

            $this->repository->Delete($task);
            DB::commit();

            return [
                'status' => true,
                'code'   => 200,
                'msg'    => 'Delivery Task Successfully Deleted',
                'data'   => ['id' => $id],
            ];

        } catch (QueryException $e) {
            DB::rollBack();
            return $this->HelpersExceptionsHttpCode->fromSQLError($e);
        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code'   => 500,
                'msg'    => 'Unexpected error: ' . $e->getMessage(),
            ];
        }
    }

    public function query(): Builder { return $this->repository->query(); }
    public function ReadAll(): Collection { return $this->repository->ReadAll(); }
    public function Count(): int { return $this->repository->Count(); }
    public function Find($id) { return $this->repository->Find($id); }

    public function AutomaticallyPaginationTable(Request $request): Collection
    {
        $query = $this->repository->query()
            ->when($request->filled('assigned'), fn($q) => $q->whereHas('assigned', fn($a) => $a->where('accounts.id', $request->get('assigned'))))
            ->when($request->filled('status'), fn($q) => $q->whereHas('history', fn($h) => $h->where('to_status', $request->get('status'))))
            ->orderByDesc('created_at');

        if (!$request->hasAny(['page', 'size'])) return $query->get();
        $page = max((int)$request->get('page', 1), 1);
        $size = (int)$request->get('size');
        if ($size > 0) $query->skip(($page - 1) * $size)->take($size);
        return $query->get();
    }
}
