<?php

namespace App\Repositories\Apps\Trackings\Monitors;

use App\Models\Apps\Trackings\Monitors\AppsTrackingsMonitors;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *  membentuk Task Repository sebagai Class Teratur Yang Berisi Tentang Peraturan Class Dan Method
 */
interface MonitorsRepositoryInterface
{
    public function Create(...$args): Model|AppsTrackingsMonitors;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|AppsTrackingsMonitors|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
