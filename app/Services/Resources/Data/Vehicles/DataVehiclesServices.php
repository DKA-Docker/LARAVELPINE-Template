<?php

namespace App\Services\Resources\Data\Vehicles;

use App\Repositories\Data\Vehicles\VehiclesRepositoryInterface;
use App\Repositories\Data\Vehicles\VehiclesRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;

class DataVehiclesServices
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new VehiclesRepository();
    }

    public function GetQuery()
    {
        return $this->repository->GetQuery();
    }

    public function ReadAll(array $filters = [], int $perPage = 10)
    {
        $query = $this->repository->GetQuery()->with('categoryDetail');

        if (isset($filters['name']) && !empty($filters['name'])) {
            $query->where('name', 'ilike', '%' . $filters['name'] . '%');
        }

        if (isset($filters['category']) && !empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function Find($id)
    {
        return $this->repository->Find($id);
    }

    public function Create(array $data)
    {
        DB::beginTransaction();
        try {
            $data['id'] = Str::uuid()->toString();
            // Create expects ...$args which merges with defaults. Passing array as first arg works.
            $model = $this->repository->Create($data);
            DB::commit();

            return [
                'status' => true,
                'code' => 200,
                'msg' => 'Success',
                'data' => $model,
                'error' => null
            ];
        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code' => 500,
                'msg' => $e->getMessage(),
                'data' => null,
                'error' => $e->getMessage()
            ];
        }
    }

    public function Update($id, array $data)
    {
        DB::beginTransaction();
        try {
            // New Update signature requires Model, so we find it first
            $model = $this->repository->Find($id);
            $model = $this->repository->Update($model, $data);
            DB::commit();

            return [
                'status' => true,
                'code' => 200,
                'msg' => 'Success',
                'data' => $model,
                'error' => null
            ];
        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code' => 500,
                'msg' => $e->getMessage(),
                'data' => null,
                'error' => $e->getMessage()
            ];
        }
    }

    public function Delete($id)
    {
        DB::beginTransaction();
        try {
            $this->repository->Delete($id);
            DB::commit();

            return [
                'status' => true,
                'code' => 200,
                'msg' => 'Success',
                'data' => null,
                'error' => null
            ];
        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code' => 500,
                'msg' => $e->getMessage(),
                'data' => null,
                'error' => $e->getMessage()
            ];
        }
    }
}
