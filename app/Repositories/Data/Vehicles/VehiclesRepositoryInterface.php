<?php

namespace App\Repositories\Data\Vehicles;

interface VehiclesRepositoryInterface
{
    public function getQuery();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
