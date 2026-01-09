<?php

namespace App\Services\Resources\Data\Vehicles;

use App\Repositories\Data\Vehicles\VehiclesRepositoryInterface;
use App\Repositories\Data\Vehicles\CategoriesRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;

class DataVehiclesServices
{
    protected $vehiclesRepository;
    protected $categoriesRepository;

    public function __construct()
    {
        $this->vehiclesRepository = new \App\Repositories\Data\Vehicles\VehiclesRepository();
        $this->categoriesRepository = new \App\Repositories\Data\Vehicles\CategoriesRepository();
    }

    // --- Categories ---

    public function createCategory(array $data)
    {
        DB::beginTransaction();
        try {
            $data['id'] = Str::uuid()->toString();
            // Account is usually mandatory, ensure it's passed or handled
            // $data['account'] = ... (handled in controller/livewire)

            $model = $this->categoriesRepository->create($data);
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

    public function updateCategory($id, array $data)
    {
        DB::beginTransaction();
        try {
            $model = $this->categoriesRepository->update($id, $data);
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

    public function deleteCategory($id)
    {
        DB::beginTransaction();
        try {
            $this->categoriesRepository->delete($id);
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

    // --- Vehicles ---

    public function createVehicle(array $data)
    {
        DB::beginTransaction();
        try {
            $data['id'] = Str::uuid()->toString();
            $model = $this->vehiclesRepository->create($data);
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

    public function updateVehicle($id, array $data)
    {
        DB::beginTransaction();
        try {
            $model = $this->vehiclesRepository->update($id, $data);
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

    public function deleteVehicle($id)
    {
        DB::beginTransaction();
        try {
            $this->vehiclesRepository->delete($id);
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
