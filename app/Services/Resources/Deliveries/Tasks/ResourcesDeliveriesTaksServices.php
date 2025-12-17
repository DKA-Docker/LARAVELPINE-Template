<?php

namespace App\Services\Resources\Deliveries\Tasks;

use App\Repositories\Apps\Deliveries\Tasks\TasksRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ResourcesDeliveriesTaksServices
{

    protected TasksRepository $repository;

    public function __construct()
    {
        $this->repository = new TasksRepository();
    }

    public function GetAllRequest(): Collection
    {
        return $this->repository->GetAllRequest();
    }

    public function GetAccount()
    {
        return $this->repository->GetAccount();
    }

    public function Create(...$args)
    {
        return $this->repository->Create(...$args);
    }

    public function ReadAllRequest(): Collection
    {
        return $this->repository->GetAllRequest();
    }

    public function ReadAll(): Collection
    {
        return $this->repository->ReadAll();
    }

    public function AutomaticallyPaginationTable(Request $request): Collection
    {
        $query = $this->repository
            ->query()
            ->when(
                $request->filled('assigned'),
                fn($q) => $q->whereHas(
                    'assigned',
                    fn($a) => $a->where('accounts.id', $request->get('assigned'))
                )
            )
            ->when(
                $request->filled('status'),
                fn($q) => $q->whereHas(
                    'history',
                    fn($h) => $h->where('to_status', $request->get('status'))
                )
            )
            ->orderByDesc('created_at');

        if (!$request->hasAny(['page', 'size'])) {
            return $query->get();
        }

        $page = max((int)$request->get('page', 1), 1);
        $size = (int)$request->get('size');

        if ($size > 0) {
            $query->skip(($page - 1) * $size)->take($size);
        }

        return $query->get();
    }


    public function Count(): int
    {
        return $this->repository->Count();
    }

    public function Find($id)
    {
        return $this->repository->Find($id);
    }

}
