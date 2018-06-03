<?php

namespace App\Events;

use App\Repositories\Statistics;
use App\Tweet;
use App\User;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Cache;
use DB;

class DashboardUpdate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var array */
    public $statistics = [];

    public function __construct()
    {
        $this->statistics = Statistics::getDashboardStatistics();
    }

    public function broadcastWith(): array
    {
        return $this->statistics;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('dashboard');
    }
}
