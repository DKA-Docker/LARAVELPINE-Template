<?php

namespace App\Events\Dashboards\Apps\Trackings\Monitors;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class Index implements ShouldBroadcast, ShouldQueue
{
    use SerializesModels;

    public mixed $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('dashboards.apps.trackings.monitors');
    }

    public function broadcastAs()
    {
        // Nama event yang akan didengar
        return 'dashboards.apps.trackings.monitors';
    }
}
