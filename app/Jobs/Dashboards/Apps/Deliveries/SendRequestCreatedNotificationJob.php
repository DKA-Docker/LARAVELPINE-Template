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

        if ($request && $user && $user->contact && $user->contact->email) {
            Mail::to($user->contact->email)->send(new RequestCreatedMail($request, $user));
        }
    }
}
