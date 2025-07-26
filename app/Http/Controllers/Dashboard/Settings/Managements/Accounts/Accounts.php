<?php

namespace App\Http\Controllers\Dashboard\Settings\Managements\Accounts;

use App\Http\Requests\Base\Accounts\CreateAccountsRequest;
use App\Http\Requests\Base\Accounts\UpdateAccountsRequest;
use App\Repositories\Base\Accounts\AccountsRepository;
use App\Repositories\Base\Accounts\Components\AccountsInformationsRepository;
use App\Services\Resources\ResourcesAccountsServices;
use Exception;
use http\Env\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Console\Application;
use Yajra\DataTables\DataTables;

class Accounts extends Controller {
    private string $theme;
    private ResourcesAccountsServices $accountsServices;
    private AccountsRepository $accountsRepository;
    private AccountsInformationsRepository $accountsInformationsRepository;

    public function __construct(null|string $theme)
    {
        $this->theme = $theme ?? env("VITE_THEME_NAME","maxton");
        $this->accountsRepository = new AccountsRepository();
        $this->accountsInformationsRepository = new AccountsInformationsRepository();
        $this->accountsServices = new ResourcesAccountsServices();
        $this->middleware(['permission:dashboards.settings.managements.accounts.view'])->only('index');
    }

    /**
     * @throws Exception
     */
    public function index(): JsonResponse|View|Application
    {
        $AuthAccount = Auth::user();
        $session = json_decode(json_encode($AuthAccount->toArray()));
        switch (request()->expectsJson()){
            case true : {
                /** @var $this->accountsRepository Merger data $data */
                $data = $this->accountsRepository->with()
                    ->with(['roles']) // eager load relasi
                    ->get();

                // Ambil prefix route tanpa bagian akhir (index, show, edit, dll.)
                $RouteGroup = Str::beforeLast(Route::currentRouteName(), '.');
                /** Cenvertion to Datatables format  */
                return DataTables::of($data)
                    ->addColumn('created_at', fn($row) => $row->created_at->format('H:i:s d-m-Y'))
                    ->addColumn('full_name', function ($row) {
                        return trim(($this->accountsInformationsRepository->ReadByID($row->information)->first_name ?? '') . ' ' . ($this->accountsInformationsRepository->ReadByID($row->information)->last_name ?? ''));
                    })
                    ->addColumn('action', function ($row) use ($AuthAccount, $RouteGroup) {
                        $buttons = [
                            '<a href="'.route("$RouteGroup.show", $row->id).'" class=""><i class="material-icons-outlined text-primary fs-4 m-1">visibility</i></a>',
                            '<a href="'.route("$RouteGroup.edit", $row->id).'" class=""><i class="material-icons-outlined text-warning fs-4 m-1">edit</i></a>',
                            '<a href="'.($AuthAccount->id == $row->id ? 'javascript::void(0);' : route("$RouteGroup.destroy", $row->id)).'"><i class="material-icons-outlined '.(($AuthAccount->id == $row->id ? 'text-grey' : 'text-danger')).' fs-4 m-1">'.(($AuthAccount->id == $row->id ? 'block' : 'delete')).'</i></a>',
                        ];
                        return implode('&nbsp;', $buttons);
                    })
                    ->addColumn('roles', function ($row) {
                        if ($row->roles->isEmpty()) {
                            return '<span class="text-danger text-center">- Belum Diberi Akses -</span>';
                        }
                        return $row->roles->map(function ($role) {
                            return '<a href="javascript:void(0);" class="btn btn-sm btn-info text-center">'. $role->name .'</a>';
                        })->implode('&nbsp;');
                    })
                    ->rawColumns(['full_name','action','roles'])
                    ->toJson();
            }
            default : {
                return view("dashboard.".$this->theme.".pages.dashboard.settings.managements.accounts.accounts", [
                    'theme' => $this->theme,
                    'session' => $session,
                    'account' => $this->accountsRepository
                ]);
            }
        }
    }

    /**
     * @throws Exception
     */
    public function store(CreateAccountsRequest $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();
        $accountCreate = $this->accountsServices->Create($validated);
        if ($accountCreate['status']){
            return redirect()
                ->to(route(Str::beforeLast(Route::currentRouteName(), '.').".index"))
                ->with('message', 'Data berhasil disimpan!');
        }else{
            return response()->json($accountCreate);
        }
    }

    public function create(): Factory|View|Application
    {
        $AuthAccount = Auth::user();
        $session = json_decode(json_encode($AuthAccount->toArray()));
        return view("dashboard.".$this->theme.".pages.dashboard.settings.managements.accounts.components.create", [
            'theme' => $this->theme,
            'session' => $session,
            'account' => $this->accountsRepository
        ]);
    }

    public function edit(\App\Models\Base\Accounts\Accounts $account): View|Application|Factory
    {
        $AuthAccount = Auth::user();
        $session = json_decode(json_encode($AuthAccount->toArray()));
        $accountData = $this->accountsRepository->Find($account->id);
        $accountData = json_decode(json_encode($accountData->toArray()));
        return view("dashboard.".$this->theme.".pages.dashboard.settings.managements.accounts.components.edit", [
            'theme' => $this->theme,
            'session' => $session,
            'account' => $accountData
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request)
    {
        $allRequest = $request->all();
        // Tambah ID dari route
        $allRequest['id'] = $request->route('account');
        // Panggil service update
        $accountCreate = $this->accountsServices->Update($allRequest);
        // Kalau gagal, cek apakah ada error validasi
        if (!$accountCreate['status']) {
            if (!empty($accountCreate['errors'])) {
                // Lempar balik sebagai validation Laravel-style
                throw ValidationException::withMessages($accountCreate['errors']);
            }
            // Kalau bukan error validasi, kirim JSON response biasa
            return response()->json([
                'message' => $accountCreate['msg'],
                'details' => $accountCreate['details'] ?? null
            ], $accountCreate['code'] ?? 500);
        }

        // Sukses, redirect balik ke index dengan flash message
        return redirect()
            ->to(route(Str::beforeLast(Route::currentRouteName(), '.') . ".index"))
            ->with('message', 'Data berhasil diupdate!');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }


}
