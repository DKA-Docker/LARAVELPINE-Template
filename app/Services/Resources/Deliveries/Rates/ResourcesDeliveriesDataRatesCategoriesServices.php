<?php

namespace App\Services\Resources\Deliveries\Rates;

use App\Repositories\Apps\Deliveries\Rates\DataRatesCategoriesRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Throwable;

class ResourcesDeliveriesDataRatesCategoriesServices
{
    protected DataRatesCategoriesRepository $repository;

    public function __construct()
    {
        $this->repository = new DataRatesCategoriesRepository();
    }

    /**
     * Store Data Rates Category
     * @param Request $request
     * @return array
     */
    public function Store(Request $request): array
    {
        DB::beginTransaction();
        try {
            $data = $request->only(['name', 'icon', 'description']);

            $category = $this->repository->Create($data);

            DB::commit();

            return [
                'status' => true,
                'code' => Response::HTTP_CREATED,
                'msg' => 'Category created successfully',
                'data' => $category
            ];

        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => $e->getMessage(),
            ];
        }
    }

    /**
     * Update Data Rates Category
     * @param Request $request
     * @param string $id
     * @return array
     */
    public function Update(Request $request, string $id): array
    {
        DB::beginTransaction();
        try {
            $category = $this->repository->Find($id);

            $data = $request->only(['name', 'icon', 'description']);

            $category->update($data);

            DB::commit();

            return [
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'Category updated successfully',
                'data' => $category
            ];

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'msg' => 'Category not found',
            ];
        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => $e->getMessage(),
            ];
        }
    }

    /**
     * Delete Data Rates Category
     * @param string $id
     * @return array
     */
    public function Delete(string $id): array
    {
        DB::beginTransaction();
        try {
            $this->repository->Delete($id);

            DB::commit();

            return [
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'Category deleted successfully',
            ];

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'msg' => 'Category not found',
            ];
        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => $e->getMessage(),
            ];
        }
    }

    public function query(): Builder
    {
        return $this->repository->query();
    }
}
