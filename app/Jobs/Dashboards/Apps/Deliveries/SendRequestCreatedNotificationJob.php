<?php

namespace App\Jobs\Dashboards\Apps\Deliveries;

use App\Mail\Dashboards\Apps\Deliveries\RequestCreatedMail;
use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Base\Accounts\Accounts;
use App\Models\Base\Apps\Deliveries\Requests\Requests;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRequestCreatedNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $requestId;
    public $userId;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 10;

    /**
     * Create a new job instance.
     */
    public function __construct(string $requestId, string $userId)
    {
        $this->requestId = $requestId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $request = Requests::with(['destinations.packages'])->find($this->requestId);
        $user = Accounts::with('contact')->find($this->userId);

        // Gunakan getRelationValue karena nama kolom 'contact' bentrok dengan nama relasi
        $contact = $user?->getRelationValue('contact');

        if ($request && $contact && $contact->email) {
            Mail::to($contact->email)->send(new RequestCreatedMail($request, $user));
        }
    }
}
