<?php

namespace App\Http\Controllers\Dashboard\Settings\Managements\Accounts;

use App\Repositories\Base\Accounts\AccountsRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Symfony\Component\Console\Application;
use Yajra\DataTables\DataTables;

class Accounts extends Controller {
    private string $theme;
    private AccountsRepository $accountsRepository;


    public function __construct(null|string $theme)
    {
        $this->theme = $theme ?? env("VITE_THEME_NAME","maxton");
        $this->accountsRepository = new AccountsRepository();

        $this->middleware(['permission:dashboards.settings.managements.accounts.view'])->only('index');
    }

    public function index(): Factory|View|Application
    {
        $AuthAccount = Auth::user();
        $session = json_decode(json_encode($AuthAccount->toArray()));
        return view("dashboard.".$this->theme.".pages.dashboard.settings.managements.accounts.accounts", [
            'theme' => $this->theme,
            'session' => $session,
            'account' => $this->accountsRepository
        ]);
    }

    /**
     * @throws Exception
     */
    public function store(): JsonResponse
    {
        $AuthID = Auth::id();

        $data = $this->accountsRepository->with()
            /*->where('id', '!=', $AuthID)*/
            ->get();

        // Ambil prefix route tanpa bagian akhir (index, show, edit, dll.)
        $RouteGroup = Str::beforeLast(Route::currentRouteName(), '.');

        return DataTables::of($data)
            ->addColumn('created_at', fn($row) => $row->created_at->format('H:i:s d-m-Y'))
            ->addColumn('action', function ($row) use ($AuthID, $RouteGroup) {
                $buttons = [
                    '<a href="'.route("$RouteGroup.show", $row->id).'" class="btn btn-sm btn-info">Lihat</a>',
                    '<a href="'.route("$RouteGroup.edit", $row->id).'" class="btn btn-sm btn-warning">Edit</a>',
                    '<a href="'.route("$RouteGroup.destroy", $row->id).'" class="btn btn-sm btn-danger '.($AuthID == $row->id ? 'disabled' : '').'">Delete</a>',
                ];

                return implode('&nbsp;', $buttons);
            })
            ->rawColumns(['action'])
            ->toJson();
    }


}
