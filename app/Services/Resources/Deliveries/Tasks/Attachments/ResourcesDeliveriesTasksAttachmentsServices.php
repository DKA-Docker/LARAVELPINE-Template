<?php

namespace App\Services\Resources\Deliveries\Tasks\Attachments;

use App\Repositories\Apps\Deliveries\Tasks\Attachments\TasksAttachmentsRepository;
use Illuminate\Database\EntityNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ResourcesDeliveriesTasksAttachmentsServices
{
    protected TasksAttachmentsRepository $repository;

    public function __construct()
    {
        $this->repository = new TasksAttachmentsRepository();
    }

    /**
     * Store Attachment
     * @param Request $request
     * @return array
     */
    public function Store(Request $request): array
    {
        DB::beginTransaction();
        try {
            // Validation is assumed to be done in Controller or FormRequest, 
            // but we can double check presence of file here if needed.
            if (!$request->hasFile('file')) {
                throw new \Exception("File is required");
            }

            $file = $request->file('file');
            $taskId = $request->input('task_id');

            // Generate metadata
            $fileName = $file->getClientOriginalName();
            $fileHash = hash_file('sha256', $file->getRealPath());
            $fileType = $file->getMimeType();
            $fileSize = $file->getSize();

            // Determine file category
            $category = match (true) {
                str_starts_with($fileType, 'image/') => 'images',
                str_starts_with($fileType, 'video/') => 'videos',
                str_starts_with($fileType, 'application/pdf') => 'documents',
                str_starts_with($fileType, 'application/msword') => 'documents',
                str_starts_with($fileType, 'application/vnd.openxmlformats-officedocument') => 'documents',
                str_starts_with($fileType, 'text/') => 'documents',
                default => 'others',
            };

            // Store file
            // Format: uploads/tasks/{category}/{task_id}/{uuid}.{ext}
            $uuid = (string) Str::uuid();
            // Use guessed extension based on mime type to ensure consistency
            $extension = $file->guessExtension() ?? $file->getClientOriginalExtension();
            $storageKey = "uploads/tasks/{$category}/{$taskId}/{$uuid}.{$extension}";
            
            $path = $file->storeAs(dirname($storageKey), basename($storageKey), 'public');
            $filePath = Storage::url($path);

            $data = [
                'id' => $uuid,
                'task' => $taskId,
                'file_name' => $fileName,
                'file_hash' => $fileHash,
                'storage_key' => $storageKey,
                'file_path' => $filePath,
                'file_type' => $fileType,
                'file_size' => $fileSize,
            ];

            $attachment = $this->repository->Create($data);

            DB::commit();

            return [
                'status' => true,
                'code' => Response::HTTP_CREATED,
                'msg' => 'Attachment created successfully',
                'data' => $attachment
            ];

        } catch (Throwable $e) {
            DB::rollBack();
            // Clean up file if it was uploaded but DB transaction failed?
            // For now, let's keep it simple. Garbage collection of orphaned files is a separate concern.
            return [
                'status' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => $e->getMessage(),
            ];
        }
    }

    /**
     * Delete Attachment
     * @param string $id
     * @return array
     */
    public function Delete(string $id): array
    {
        DB::beginTransaction();
        try {
            $attachment = $this->repository->Find($id);

            // Delete from storage
            if (Storage::disk('public')->exists($attachment->storage_key)) {
                Storage::disk('public')->delete($attachment->storage_key);
            }

            // Delete from DB
            $this->repository->Delete($id);

            DB::commit();

            return [
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'Attachment deleted successfully',
            ];

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             DB::rollBack();
             return [
                'status' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'msg' => 'Attachment not found',
            ];
        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => $e->getMessage(),
            ];
        }
    }
}
