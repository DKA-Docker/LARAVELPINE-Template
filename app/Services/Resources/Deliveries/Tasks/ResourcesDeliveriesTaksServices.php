<?php

namespace App\Services\Resources\Deliveries\Tasks;

use App\Repositories\Apps\Deliveries\Tasks\TasksRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ResourcesDeliveriesTaksServices
{

    protected TasksRepository $repository;

    public function __construct()
    {
        $this->repository = new TasksRepository();
    }

    public function AutomaticallyPaginationTable(Request $request): Collection
    {
        if (!$request->hasAny(['page', 'perPage'])) {
            return $this->repository->query()->get();
        }

        /** @var $page
         *
         * mulai pagination manual kalau ada page/size
         * default ke 1 kalau orang cuma kirim size
         */
        $page = (int)  $request->get('page', 1);
        $size = (int) $request->get('size', 1);

        /**
         * kalau size nggak dikirim, jangan dipaksa 10 → anggap no limit
         */
        if ($size != null) {
            $size = (int) $size;
            $size = $size < 1  ? null : $size;
            // kalau di kasih angka aneh (<=0), anggap no limit
        }

        $query = $this->repository->query();

        if ($size !== null) {
            $page = max($page, 1);
            $offset = ($page - 1) * $size;

            $query->skip($offset)->take($size);
        }

        return $query->get();
    }

    public function Count():int
    {
        return $this->repository->Count();
    }

}
