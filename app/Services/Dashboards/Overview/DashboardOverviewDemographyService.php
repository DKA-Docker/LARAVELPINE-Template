<?php

namespace App\Services\Dashboards\Overview;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasksGeos;
use App\Models\Data\Geos\DataGeosDistricts;
use App\Models\Data\Geos\DataGeosVillages;
use Illuminate\Support\Facades\DB;

use App\Models\Data\Geos\DataGeosProvinces;
use App\Models\Data\Geos\DataGeosRegencies;

class DashboardOverviewDemographyService
{
    public function getProvinces()
    {
        return DataGeosProvinces::orderBy('name')->pluck('name', 'id');
    }

    public function getRegencies($provinceId)
    {
        return DataGeosRegencies::where('province_id', $provinceId)->orderBy('name')->pluck('name', 'id');
    }

    public function getDistricts($regencyId)
    {
        return DataGeosDistricts::where('regency_id', $regencyId)->orderBy('name')->pluck('name', 'id');
    }

    public function getVillages($districtId)
    {
        return DataGeosVillages::where('district_id', $districtId)->orderBy('name')->pluck('name', 'id');
    }

    public function getDemographics(array $filters = [], int $limit = 10): array
    {
        $query = AppsDeliveriesTasksGeos::query();
        
        $targetProperty = 'selectedProvince';

        if (!empty($filters['village_id'])) {
             // Leaf node, maybe no action or unselect? 
             $targetProperty = null; // No deeper level
             $query->where('village', $filters['village_id']);
             $table = 'data_geos_villages';
             $foreignKey = 'apps_deliveries_tasks_geos.village';
             $joinKey = 'data_geos_villages.id';
             $labelColumn = 'data_geos_villages.name';
        } elseif (!empty($filters['district_id'])) {
             $targetProperty = 'selectedVillage';
             $query->where('district', $filters['district_id']);
             $table = 'data_geos_villages';
             $foreignKey = 'apps_deliveries_tasks_geos.village';
             $joinKey = 'data_geos_villages.id';
             $labelColumn = 'data_geos_villages.name';
        } elseif (!empty($filters['regency_id'])) {
             $targetProperty = 'selectedDistrict';
             $query->where('regency', $filters['regency_id']);
             $table = 'data_geos_districts';
             $foreignKey = 'apps_deliveries_tasks_geos.district';
             $joinKey = 'data_geos_districts.id';
             $labelColumn = 'data_geos_districts.name';
        } elseif (!empty($filters['province_id'])) {
             $targetProperty = 'selectedRegency';
             $query->where('province', $filters['province_id']);
             $table = 'data_geos_regencies';
             $foreignKey = 'apps_deliveries_tasks_geos.regency';
             $joinKey = 'data_geos_regencies.id';
             $labelColumn = 'data_geos_regencies.name';
        } else {
             // Default: Show Provinces
             $targetProperty = 'selectedProvince';
             $table = 'data_geos_provinces';
             $foreignKey = 'apps_deliveries_tasks_geos.province';
             $joinKey = 'data_geos_provinces.id';
             $labelColumn = 'data_geos_provinces.name';
        }

        $data = $query->join($table, $foreignKey, '=', $joinKey)
            ->select($labelColumn . ' as label', $joinKey . ' as id', DB::raw('count(*) as value'))
            ->groupBy($labelColumn, $joinKey)
            ->orderByDesc('value')
            ->limit($limit)
            ->get();

        return [
            'labels' => $data->pluck('label')->toArray(),
            'series' => $data->pluck('value')->toArray(),
            'ids' => $data->pluck('id')->toArray(),
            'target_property' => $targetProperty,
        ];
    }
}
