<?php

namespace App\Repositories\Apps\Deliveries\Tasks\Attachments;

use App\Models\Apps\Deliveries\Tasks\Attachments\AppsDeliveriesTasksAttachments;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TasksAttachmentsRepository implements TasksAttachmentsRepositoryInterface
{
    public function Create(array $data): Model|AppsDeliveriesTasksAttachments
    {
        return AppsDeliveriesTasksAttachments::create($data);
    }

    public function Find(string $id): null|Collection|AppsDeliveriesTasksAttachments|Model
    {
        return AppsDeliveriesTasksAttachments::findOrFail($id);
    }

    public function Delete(string $id): bool|null
    {
        $model = $this->Find($id);
        return $model->delete();
    }

    public function query(): Builder
    {
        return AppsDeliveriesTasksAttachments::query();
    }
}
