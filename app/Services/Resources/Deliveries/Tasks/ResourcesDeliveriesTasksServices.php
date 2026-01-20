<?php

namespace App\Services\Resources\Deliveries\Tasks;

use App\Helpers\Exceptions\HelpersExceptionsHttpCode;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Repositories\Apps\Deliveries\Histories\HistoriesRepository;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class ResourcesDeliveriesTasksServices
{
    protected TasksRepository $repository;
    protected ResourcesDeliveriesTasksGeosService $geos;
    protected TasksAssignsRepository $assigns;
    protected HelpersExceptionsHttpCode $HelpersExceptionsHttpCode;
    protected HistoriesRepository $histories;

    public function __construct()
    {
        $this->repository = new TasksRepository();
        $this->geos = new ResourcesDeliveriesTasksGeosService();
        $this->assigns = new TasksAssignsRepository();
        $this->HelpersExceptionsHttpCode = new HelpersExceptionsHttpCode();
        $this->histories = new HistoriesRepository();
    }

    /**
     * Creates Delivery Task (atomik) + afterCommit
     * @return array{status:bool,code:int,msg:string,data?:mixed}
     * @throws Throwable
     */
    /**
     * Finds Task for Detail View with all necessary relations
     */
    public function FindByID(string $id)
    {
        return $this->repository->Find($id);
    }


    /**
     * @param array $payload
     * @return array
     * @throws Throwable
     */
    public function Create(array $payload): array
    {
        DB::beginTransaction(); // Mengaktifkan kembali transaksi database
        try {
            // 1. Ambil ID User login sebagai pembuat task
            $currentUserId = Auth::id();

            // 2. Ambil List Driver dari inputan 'assigned' (format array keys dari Livewire)
            $driverIds = isset($payload['assigned']) ? array_keys($payload['assigned']) : [];

            // 3. Persiapkan data untuk Repository Utama
            $taskData = $payload;
            $taskData['account'] = $currentUserId;

            // 4. ambil data vehicle dari inputan 'vehicle_id'
            $taskData['vehicle'] =  $payload['vehicle_id'];

            // 4. Simpan Main Task
            $taskCreated = $this->repository->Create($taskData);

            // 5. Simpan Data Assign menggunakan Repository $this->assigns
            if ($taskCreated && !empty($driverIds)) {
                foreach ($driverIds as $driverId) {
                   $result = $this->assigns->Create([
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

            // 7. Simpan History Awal (Contoh: Status 'pending' atau 'created')
            // Menyesuaikan dengan $this->histories yang diinisialisasi di constructor
            if ($taskCreated) {
               $response = $this->histories->Create([
                    'task'        => $taskCreated->id,
                    'account'     => $currentUserId,
                    'to_status'   => 'to do', // Status awal default
                    'title' => null,
                    'description' => $taskData['name'],
                    'name'        => $taskData['first_name']
                ]);

            }

            DB::afterCommit(function () use ($taskCreated, $currentUserId) {
                 try {
                     $messaging = Firebase::messaging();
                     /** @var AppsDeliveriesTasks $taskLoaded */
                     $taskLoaded = $taskCreated->load(['assigned.firebase', 'assigned.information', 'vehicle', 'destination.packages']);
                     $creator = Auth::user()?->account?->information?->first_name ?? 'Admin';

                     $notifTitle = "Kamu diberikan tugas dari {$creator}";

                     // Gunakan getRelationValue karena nama relasi 'vehicle' sama dengan nama kolom foreign key
                     $vehicleRel = $taskLoaded->getRelationValue('vehicle');
                     $vehicleName = $vehicleRel->name ?? 'Kendaraan';
                     $vehiclePlate = $vehicleRel->plate ?? '-';

                     // Gunakan getRelationValue karena nama relasi 'destination' sama dengan nama kolom foreign key
                     $destinationRel = $taskLoaded->getRelationValue('destination');
                     $receiptName = $destinationRel->receipt_name ?? 'Penerima';
                     $receiptAddress = $destinationRel->receipt_address ?? 'Alamat';

                     // Hitung paket
                     $packages = $destinationRel->packages ?? collect([]);
                     $totalItems = $packages->count();
                     $totalQty = $packages->sum('qty');

                     $notifBody = "Hai, Kamu mendapatkan Task Baru Dari {$creator} pengiriman Ke {$receiptAddress} menggunakan {$vehicleName} dengan Plate kendaraan {$vehiclePlate} dengan jumlah {$totalItems} Paket, Jumlah Paketnya {$totalQty} total";

                     foreach ($taskLoaded->assigned as $assign) {
                         // Gunakan getRelationValue() untuk menghindari konflik dengan kolom 'firebase' yang berisi string UUID
                         // $assign adalah model Account karena relasi 'assigned' adalah BelongsToMany
                         $firebaseRel = $assign->getRelationValue('firebase');
                         $token = $firebaseRel->token ?? null;

                         if ($token) {
                             Log::info("Sending FCM for Task $taskCreated->id", [
                                 'token' => substr($token, 0, 10) . '...',
                                 'assign_id' => $assign->id
                             ]);

                             $messaging = Firebase::messaging();

                            $message = CloudMessage::new()
                                ->toToken(token: $token)
                                ->withData([
                                    'action' => 'TASK_ASSIGNED',
                                    'task_id' => $taskCreated->id,
                                    'creator' => $creator,
                                    'title' => $notifTitle,
                                    'body' => $notifBody
                                ]);

                            $result = $messaging->send($message);
                            Log::info("FCM Sent Successfully", ['result' => json_encode($result)]);
                         } else {
                             Log::warning("No FCM Token for assigned account", ['assign_id' => $assign->id]);
                         }
                     }
                 } catch (Throwable $e) {
                     Log::error("Failed to send FCM: " . $e->getMessage());
                     Debugbar::error("Failed to send FCM: " . $e->getMessage());
                 }
            });

            DB::commit();

            return [
                'status' => true,
                'code'   => 201,
                'msg'    => 'Delivery Task Successfully Created',
                'data'   => $taskCreated->load(['assigned', 'geos', 'history']),
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
     * @throws Throwable
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
                'code'   => ResponseAlias::HTTP_OK,
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
     * @throws Throwable
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

    /**
     * @throws Throwable
     */
    public function FindByAssign($id) : array
    {
        DB::beginTransaction();
        try {
            $task = $this->assigns->query()->where('task', $id)->get();

            if (!$task) {
                DB::rollBack();
                return [
                    'status' => false,
                    'code'   => 404,
                    'msg'    => 'Delivery Assign not found',
                ];
            }

            DB::commit();

            return [
                'status' => true,
                'code'   => 200,
                'msg'    => 'Delivery Assign Successfully Read Data',
                'data'   => $task,
            ];
        } catch (QueryException $e) {
            DB::rollBack();
            return $this->HelpersExceptionsHttpCode->fromSQLError($e);
        }catch (Throwable $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code'   => 500,
                'msg'    => 'Unexpected error: ' . $e->getMessage(),
            ];
        }
    }

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
