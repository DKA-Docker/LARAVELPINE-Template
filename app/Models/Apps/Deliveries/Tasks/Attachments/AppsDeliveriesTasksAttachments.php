<?php

namespace App\Models\Apps\Deliveries\Tasks\Attachments;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesTasksAttachments extends Model
{
    /** @use HasFactory<\Database\Factories\Apps\Deliveries\Tasks\Attachments\AppsDeliveriesTasksAttachmentsFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'apps_deliveries_tasks_attachments';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'task',
        'file_name',
        'file_hash',
        'storage_key',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(AppsDeliveriesTasks::class, 'task_id');
    }
}
