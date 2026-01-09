<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Settings\Vehicles\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Data\Vehicles\DataVehicleCategories;

class Edit extends Controller
{
    public function index(Request $request, $id)
    {
        $service = new \App\Services\Resources\Data\Vehicles\DataVehicleCategoriesServices();
        $category = $service->Find($id);
        
        return view('dashboards.settings.vehicles.categories.edit', [
            'category' => $category
        ]);
    }
}
