<?php

namespace App\Http\Controllers\Dashboard\Settings\Privileges\Permissions;

use App\Repositories\Base\Accounts\AccountsRepository;
use App\Repositories\Base\Permissions\PermissionsRepository;
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

class Permissions extends Controller {
    private string $theme;
    private PermissionsRepository $permissionsRepository;


    public function __construct(null|string $theme)
    {
        $this->theme = $theme ?? env("VITE_THEME_NAME","maxton");
        $this->permissionsRepository = new PermissionsRepository();

        //$this->middleware(['permission:dashboards.settings.privileges.permissions.view'])->only('index');
    }

    public function index(): Factory|View|Application
    {
        $AuthAccount = Auth::user();
        $session = json_decode(json_encode($AuthAccount->toArray()));
        return view("dashboard.".$this->theme.".pages.dashboard.settings.privileges.permissions.permissions", [
            'theme' => $this->theme,
            'session' => $session
        ]);
    }

    /**
     * @throws Exception
     */
    public function store(): JsonResponse
    {
        $AuthID = Auth::id();

        $data = $this->permissionsRepository->ReadAll();

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
