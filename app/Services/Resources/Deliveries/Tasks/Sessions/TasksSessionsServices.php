<?php

namespace App\Services\Resources\Deliveries\Tasks\Sessions;

use App\Helpers\Exceptions\HelpersExceptionsHttpCode;
use App\Models\Apps\Deliveries\Tasks\Sessions\AppsDeliveriesTasksSessions;
use App\Repositories\Apps\Deliveries\Tasks\Sessions\TasksSessionsRepository;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
     */
    public function Create(array $payload): array
    {
        DB::beginTransaction();
        try {
            // Generate UUID manually
            $payload['id'] = Str::uuid()->toString();
            // Set account to current logged in user
            $payload['account'] = Auth::id();

            $session = $this->repository->Create($payload);
            DB::commit();

            return [
                'status' => true,
                'code'   => 201,
                'msg'    => 'Session Successfully Created',
                'data'   => $session,
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
     */
    public function Update(string $id, array $payload): array
    {
        DB::beginTransaction();
        try {
            /** @var AppsDeliveriesTasksSessions|null $session */
            $session = $this->repository->Find($id);

            if (!$session) {
                DB::rollBack();
                return [
                    'status' => false,
                    'code'   => 404,
                    'msg'    => 'Session not found',
                ];
            }

            $this->repository->Update($session, $payload);
            DB::commit();

            return [
                'status' => true,
                'code'   => 200,
                'msg'    => 'Session Successfully Updated',
                'data'   => $session,
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
     */
    public function Delete(string $id): array
    {
        DB::beginTransaction();
        try {
            /** @var AppsDeliveriesTasksSessions|null $session */
            $session = $this->repository->Find($id);

            if (!$session) {
                DB::rollBack();
                return [
                    'status' => false,
                    'code'   => 404,
                    'msg'    => 'Session not found',
                ];
            }

            $this->repository->Delete($session);
            DB::commit();

            return [
                'status' => true,
                'code'   => 200,
                'msg'    => 'Session Successfully Deleted',
                'data'   => ['id' => $id],
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
