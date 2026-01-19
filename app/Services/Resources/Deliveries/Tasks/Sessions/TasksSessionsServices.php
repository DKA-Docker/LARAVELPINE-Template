<?php

namespace App\Services\Resources\Deliveries\Tasks\Sessions;

use App\Helpers\Exceptions\HelpersExceptionsHttpCode;
use App\Models\Apps\Deliveries\Tasks\Sessions\AppsDeliveriesTasksSessions;
use App\Repositories\Apps\Deliveries\Tasks\Sessions\TasksSessionsRepository;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class TasksSessionsServices
{
    protected TasksSessionsRepository $repository;
    protected HelpersExceptionsHttpCode $helpersExceptionsHttpCode;

    public function __construct()
    {
        $this->repository = new TasksSessionsRepository();
        $this->helpersExceptionsHttpCode = new HelpersExceptionsHttpCode();
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
                'account'       => ['required', 'uuid'],
                'task'          => ['required', 'uuid'],
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

            $updatedData = $this->repository->Update(
                find: [
                    'id' => $id
                ],
                data: $newData
            );

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
            // Menggunakan gaya 'find' seperti pada Update
            $deleted = $this->repository->Delete(
                data: [
                    'id' => $id
                ]
            );

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
