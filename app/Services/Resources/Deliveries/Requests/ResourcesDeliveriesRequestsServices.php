<?php

namespace App\Services\Resources\Deliveries\Requests;

use App\Repositories\Apps\Deliveries\Requests\RequestsRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ResourcesDeliveriesRequestsServices
{

    protected RequestsRepository $repository;

    public function __construct(){
        $this->repository = new RequestsRepository();
    }


    public function Create(Request $request)
    {
        return $this->repository->create();
    }
    public function ReadAll(): Collection
    {
        return $this->repository->ReadAll();
    }

    public function AutomaticallyPaginationTable(Request $request): Collection {
        /** kalau nggak ada page & size di query, balikin semua data */
        if (!$request->hasAny(['page', 'size'])) {
            return $this->repository->query()->get();
        }

        /** @var $page
         *
         * mulai pagination manual kalau ada page/size
         * default ke 1 kalau orang cuma kirim size
         */
        $page = (int) $request->get('page', 1);
        $size = (int) $request->get('size', 1);

        /**
         * kalau size nggak dikirim, jangan dipaksa 10 → anggap no limit
         */
        if ($size !== null) {
            $size = (int) $size;
            $size = $size < 1 ? null : $size;     // kalau dikasih angka aneh (<=0), anggap no limit
        }

        $query = $this->repository->query();

        if ($size !== null) {
            $page   = max($page, 1);
            $offset = ($page - 1) * $size;

            $query->skip($offset)->take($size);
        }

        return $query->get();
    }

    public function Count(): int
    {
        return $this->repository->Count();
    }
}
