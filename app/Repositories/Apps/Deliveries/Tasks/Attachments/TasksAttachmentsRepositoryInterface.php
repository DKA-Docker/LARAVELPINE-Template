<?php

namespace App\Repositories\Apps\Deliveries\Tasks\Attachments;

use App\Models\Apps\Deliveries\Tasks\Attachments\AppsDeliveriesTasksAttachments;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TasksAttachmentsRepositoryInterface
{
    public function Create(array $data): Model|AppsDeliveriesTasksAttachments;

    public function Find(string $id): null|Collection|AppsDeliveriesTasksAttachments|Model;

    public function Delete(string $id): bool|null;

    public function query(): Builder;
}
