<?php

namespace App\Services\Resources\Deliveries\Requests;

use App\Jobs\Dashboards\Apps\Deliveries\SendRequestCreatedNotificationJob;
use App\Models\Base\Accounts\Accounts;
use App\Repositories\Apps\Deliveries\Requests\Destinations\Packages\RequestsDestinationsPackagesRepository;
use App\Repositories\Apps\Deliveries\Requests\Destinations\RequestsDestinationsRepository;
use App\Repositories\Apps\Deliveries\Requests\RequestsRepository;
use Barryvdh\Debugbar\Facades\Debugbar;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ResourcesDeliveriesRequestsServices
{

    protected RequestsRepository $repositoryRequest;
    protected RequestsDestinationsRepository $repositoryRequestDestinations;
    protected RequestsDestinationsPackagesRepository $repositoryRequestsDestinationsPackages;

    public function __construct(){
        $this->repositoryRequest = new RequestsRepository();
        $this->repositoryRequestDestinations = new RequestsDestinationsRepository();
        $this->repositoryRequestsDestinationsPackages = new RequestsDestinationsPackagesRepository();
    }

    public function Create(array $args): array
    {
        /**
         * @var Accounts $account */
        $account = Auth::user();

        try {
            DB::beginTransaction();

            /** pisahkan destinations dari payload utama supaya nggak ikut ke mass assignment */
            $destinationsPayload = $args['destinations'] ?? [];
            unset($args['destinations']); // buang dari payload utama

            /** buat record request utama */
            $RequestResponse = $this->repositoryRequest->Create([
                'id'      => (string) Str::uuid(),
                'account' => $account->id,
                ...$args, // sisanya payload request
            ]);

            /** kalau ada destinasi, proses satu per satu */
            collect($destinationsPayload)->each(function ($destination) use ($account, $RequestResponse) {
                // pastikan $destination adalah array biasa
                $destination = (array) $destination;

                /** pisahkan packages dari data destinasi */
                $packagesPayload = $destination['packages'] ?? [];
                unset($destination['packages']);

                $RequestDestinationsResponse = $this->repositoryRequestDestinations->Create([
                    'id'      => (string) Str::uuid(),
                    'account' => $account->id,
                    'request' => $RequestResponse->id,
                    ...$destination, // isi receipt_name, receipt_phone, dst
                ]);

                /** kalau ada packages di destinasi ini, buat satu per satu */
                collect($packagesPayload)->each(function ($package) use ($account, $RequestDestinationsResponse) {
                    $package = (array) $package;

                    $this->repositoryRequestsDestinationsPackages->Create([
                        'id'          => (string) Str::uuid(),
                        'account'     => $account->id,
                        'destination' => $RequestDestinationsResponse->id,
                        ...$package, // name, qty, unit, etc
                    ]);
                });
            });

            DB::afterCommit(function () use ($RequestResponse, $account) {
                // Dispatch notification job
                SendRequestCreatedNotificationJob::dispatch($RequestResponse->id, $account->id);
            });

            DB::commit();
            
            return [
                'status'  => true,
                'message' => 'Berhasil membuat request pengiriman.',
                'data'    => $RequestResponse,
            ];
        } catch (Throwable $e) {
            DB::rollBack();

            // optional: logging
            // report($e);

            return [
                'status'  => false,
                'message' => $e->getMessage(), // dari exception
            ];
        }
    }

    public function Find($id)
    {
        return $this->repositoryRequest->Find($id);
    }

    public function Update($id, array $data): array
    {
        try {
            DB::beginTransaction();

            $request = $this->repositoryRequest->Find($id);
            
            // Only update fillable fields from data
            $request->update($data);

            DB::commit();

            return [
                'status'  => true,
                'message' => 'Berhasil memperbarui request pengiriman.',
                'data'    => $request,
            ];
        } catch (Throwable $e) {
            DB::rollBack();

            return [
                'status'  => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function query(): Builder
    {
        return $this->repositoryRequest->query();
    }

    public function ReadAll(): Collection
    {
        return $this->repositoryRequest->ReadAll();
    }

    public function AutomaticallyPaginationTable(Request $request): Collection {
        /** kalau nggak ada page & size di query, balikin semua data */

        if (!$request->hasAny(['page', 'size'])) {
            return $this->repositoryRequest->query()->get();
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

        $query = $this->repositoryRequest->query();

        if ($size !== null) {
            $page   = max($page, 1);
            $offset = ($page - 1) * $size;

            $query->skip($offset)->take($size);
        }

        return $query->get();
    }

    public function Count(): int
    {
        return $this->repositoryRequest->Count();
    }
}
