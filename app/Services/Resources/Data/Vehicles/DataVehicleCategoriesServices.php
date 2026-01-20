<?php

namespace App\Services\Resources\Data\Vehicles;

use App\Repositories\Data\Vehicles\CategoriesRepositoryInterface;
use App\Repositories\Data\Vehicles\CategoriesRepository;
use App\Models\Data\Vehicles\DataVehicleCategories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;

class DataVehicleCategoriesServices
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new CategoriesRepository();
    }

    public function GetQuery()
    {
        return $this->repository->GetQuery();
    }

    public function ReadAll(array $filters = [], int $perPage = 10)
    {
        $query = $this->repository->GetQuery();

        if (isset($filters['name']) && !empty($filters['name'])) {
            $query->where('name', 'ilike', '%' . $filters['name'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function GetDropdown()
    {
        return $this->repository->GetQuery()->orderBy('name')->get();
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
            // Account logic handled in controller/livewire
            
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
            $model = $this->repository->Update($id, $data);
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
