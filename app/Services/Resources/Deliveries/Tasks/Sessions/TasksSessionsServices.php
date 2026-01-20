<?php

namespace App\Services\Resources\Deliveries\Tasks\Sessions;

use App\Helpers\Exceptions\HelpersExceptionsHttpCode;
use App\Repositories\Apps\Deliveries\Histories\HistoriesRepository;
use App\Repositories\Apps\Deliveries\Tasks\Sessions\TasksSessionsRepository;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Throwable;

class TasksSessionsServices
{
    protected TasksSessionsRepository $repository;
    protected HelpersExceptionsHttpCode $helpersExceptionsHttpCode;
    protected HistoriesRepository $histories;

    public function __construct()
    {
        $this->repository = new TasksSessionsRepository();
        $this->helpersExceptionsHttpCode = new HelpersExceptionsHttpCode();
        $this->histories = new HistoriesRepository();
    }

    /**
     * Create Delivery Task Session
     * @param array $payload
     * @return array
     * @throws Throwable
     */
    public function Create(array $payload): array
    {
        DB::beginTransaction();
        try {

            $validated = Validator::make($payload, [
                'id'            => ['nullable', 'string'],
                'account'       => ['required', 'uuid'],
                'task'          => ['required', 'uuid'],
                'route'         => ['nullable', 'array', 'min:0'], // min:0 membolehkan array kosong untuk "EMPTY"
                'route.*'       => ['array', 'size:4'], // Memastikan setiap titik punya 4 elemen (X, Y, Z, M)
                'route.*.*'     => ['numeric'],
                'description'   => ['nullable', 'string'],
                'time_started'  => ['nullable', 'date_format:Y-m-d H:i:s'], // Mewajibkan format spesifik
                'time_received' => ['nullable', 'date_format:Y-m-d H:i:s'], // Mewajibkan format spesifik
            ])->validate();
            /** @var $data
             * Created Data
             */
            $data = $this->repository->Create($validated);

            DB::afterCommit(function () use ($data) {
                $this->histories->Create([
                    'task'        => $data['task'],
                    'account'     => $data['account'],
                    'status'   => 'PICKUP', // Status awal default
                    'title' => "Barang Sudah Diambil Kurir"
                ]);
                $this->histories->Create([
                    'task'        => $data['task'],
                    'account'     => $data['account'],
                    'status'   => 'DELIVERING',
                    'title' => "Kurir Dalam Perjalanan"
                ]);
            });

            DB::commit();
            /** Returning Variable */
            return [
                'status' => true,
                'code'   => 201,
                'msg'    => 'Session Successfully Created',
                'data'   => $data,
            ];
        } catch (QueryException $e) {
            Debugbar::warning($e);
            DB::rollBack();
            return $this->helpersExceptionsHttpCode->fromSQLError($e);
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
     * Update Delivery Task Session
     * @param string $id
     * @param array $payload
     * @return array
     * @throws Throwable
     */
    public function Update(string $id, array $payload): array
    {
        DB::beginTransaction();
        try {
            $newData = Validator::make($payload, [
                'account'       => ['nullable', 'uuid'],
                'task'          => ['nullable', 'uuid'],
                'route'         => ['nullable', 'array', 'min:0'], // min:0 membolehkan array kosong untuk "EMPTY"
                'route.*'       => ['array', 'size:4'], // Memastikan setiap titik punya 4 elemen (X, Y, Z, M)
                'route.*.*'     => ['numeric'],
                'time_started'  => ['nullable', 'date_format:Y-m-d H:i:s'], // Mewajibkan format spesifik
                'time_received' => ['nullable', 'date_format:Y-m-d H:i:s'], // Mewajibkan format spesifik
            ])->validate();

            // Logic PostGIS: Jika ada data route (array of points), append ke existing linestring
            if (isset($newData['route']) && is_array($newData['route'])) {
                $routeRaw = "route";
                $hasValidPoints = false;
                foreach ($newData['route'] as $point) {
                    if (is_array($point) && count($point) >= 4) {
                        $rawPoint = "ST_SetSRID(ST_MakePoint({$point[0]}, {$point[1]}, {$point[2]}, {$point[3]}), 4326)";
                        $routeRaw = "ST_AddPoint($routeRaw, $rawPoint)";
                        $hasValidPoints = true;
                    }
                }

                if ($hasValidPoints && $routeRaw !== "route") {
                    $newData['route'] = DB::raw($routeRaw);
                } else {
                    unset($newData['route']);
                }
            }

            $sessionData = $this->repository->Find($id);

            $updatedData = $this->repository->Update(
                find: [
                    'id' => $id
                ],
                data: $newData
            );

            DB::afterCommit(function () use ($newData, $sessionData) {
                if (isset($newData['time_received']) && $newData['time_received'] != null){
                    $this->histories->Create([
                        'task'        => $sessionData->task,
                        'account'     => Auth::id(),
                        'status'   => 'DELIVERED',
                        'title' => "Barang Diterima",
                    ]);
                }
            });

            if ($updatedData){

                DB::commit();

                return [
                    'status' => true,
                    'code'   => 200,
                    'msg'    => 'Session Successfully Updated',
                    'data'   => $newData,
                ];
            } else{
                DB::rollBack();
                return [
                    'status' => false,
                    'code'   => 404,
                    'msg'    => 'Session not found',
                ];
            }
        }catch (ValidationException $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code'   => 422,
                'msg'    => 'Validation Error',
                'errors' => $e->errors(),
            ];
        } catch (QueryException $e) {
            DB::rollBack();
            return $this->helpersExceptionsHttpCode->fromSQLError($e);
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
     * Delete Delivery Task Session
     * @param string $id
     * @return array
     * @throws Throwable
     */
    /**
     * Delete Delivery Task Session
     * @param string $id
     * @return array
     * @throws Throwable
     */
    public function Delete(string $id): array
    {
        DB::beginTransaction();
        try {
            $sessionData = $this->repository->Find($id);
           // Menggunakan gaya 'find' seperti pada Update
            $deleted = $this->repository->Delete(
                data: [
                    'id' => $id
                ]
            );

            DB::afterCommit(function () use ($id, $sessionData) {

                $this->histories->Create([
                    'account' => Auth::id(),
                    'task' => $sessionData->task,
                    'status'   => 'CANCELED',
                    'title' => "Pengiriman Dibatalkan"
                ]);
            });

            if ($deleted) {
                DB::commit();

                return [
                    'status' => true,
                    'code'   => 200,
                    'msg'    => 'Session Successfully Deleted',
                    'data'   => ['id' => $id],
                ];
            } else {
                DB::rollBack();
                return [
                    'status' => false,
                    'code'   => 404,
                    'msg'    => 'Session not found',
                ];
            }

        } catch (QueryException $e) {
            DB::rollBack();
            return $this->helpersExceptionsHttpCode->fromSQLError($e);
        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code'   => 500,
                'msg'    => 'Unexpected error: ' . $e->getMessage(),
            ];
        }
    }

    public function Find(string $id)
    {
        return $this->repository->Find($id);
    }

    public function ReadAll()
    {
        return [
            'status' => true,
            'code'   => 200,
            'msg'    => 'Successfully Read Data',
            'data'   => $this->repository->ReadAll()
        ];
    }
}
