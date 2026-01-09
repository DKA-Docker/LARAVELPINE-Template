<?php

namespace App\Repositories\Data\Vehicles;

interface CategoriesRepositoryInterface
{
    public function GetQuery();
    public function Find($id);
    public function Create(array $data);
    public function Update($id, array $data);
    public function Delete($id);
}
