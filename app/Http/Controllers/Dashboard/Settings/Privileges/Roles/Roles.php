<?php

namespace App\Http\Controllers\Dashboard\Settings\Privileges\Roles;

use App\Repositories\Base\Accounts\AccountsRepository;
use App\Repositories\Base\Permissions\PermissionsRepository;
use App\Repositories\Base\Permissions\RolesRepository;
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

class Roles extends Controller {
    private string $theme;
    private RolesRepository $rolesRepository;

    public function __construct(null|string $theme)
    {
        $this->theme = $theme ?? env("VITE_THEME_NAME","maxton");
        $this->rolesRepository = new RolesRepository();

        $this->middleware(['permission:dashboards.settings.privileges.roles.view'])->only('index');
    }

    public function index(): Factory|View|Application|JsonResponse
    {
        /**
         * Action data in the auth user the view of layout data to Blade Data
         */
        switch (request()->expectsJson()){
            case true : {
                $ReadAll = $this->rolesRepository
                    ->ReadAll();
                return response()->json(
                    data : $ReadAll,
                    headers: [
                        'Content-Type' => 'application/json'
                    ]
                );
            }
            default : {
                $AuthAccount = Auth::user();
                $session = json_decode(json_encode($AuthAccount->toArray()));
                return view("dashboard.".$this->theme.".pages.dashboard.settings.privileges.roles.roles", [
                    'theme' => $this->theme,
                    'session' => $session
                ]);
            }
        }

    }

    /**
     * @throws Exception
     */
    public function store(): JsonResponse
    {
        $AuthID = Auth::id();

        $data = $this->rolesRepository->ReadAll();

        // Ambil prefix route tanpa bagian akhir (index, show, edit, dll.)
        $RouteCurrentGroup = Str::beforeLast(Route::currentRouteName(), '.');

        return DataTables::of($data)
            ->addColumn('created_at', fn($row) => $row->created_at->format('H:i:s d-m-Y'))
            ->addColumn('action', function ($row) use ($AuthID, $RouteCurrentGroup) {
                $buttons = [
                    '<a href="'.route("$RouteCurrentGroup.show", $row->id).'" class="btn btn-sm btn-info">Lihat</a>',
                    '<a href="'.route("$RouteCurrentGroup.edit", $row->id).'" class="btn btn-sm btn-warning">Edit</a>',
                    '<a href="'.route("$RouteCurrentGroup.destroy", $row->id).'" class="btn btn-sm btn-danger '.($AuthID == $row->id ? 'disabled' : '').'">Delete</a>',
                ];

                return implode('&nbsp;', $buttons);
            })
            ->rawColumns(['action'])
            ->toJson();
    }


}
