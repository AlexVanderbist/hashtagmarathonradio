<?php

namespace App\Events;

use App\Tweet;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DashboardUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $totalTweets = 0;
    public $totalUsers = 0;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->totalTweets = Tweet::all()->count();
        $this->totalUsers = User::all()->count();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('dashboard');
    }
}
