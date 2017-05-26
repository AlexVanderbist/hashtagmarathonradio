<?php

namespace App\Events;

use App\Tweet;
use App\User;
use Carbon\Carbon;
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
    public $tweetsPerMinute = 0;
    public $usersWithMostTweets = 0;

    public function __construct()
    {
        $this->totalTweets = Tweet::all()->count();

        $this->totalUsers = User::all()->count();

        $this->tweetsPerMinute = Tweet::where('tweeted_at', '>', Carbon::now()->subMinute())->count();

        // NEED TO CACHE THIS HARD
        $this->usersWithMostTweets = User::withCount('tweets')->orderBy('tweets_count', 'desc')->take(50)->get()->toArray(); // toArray to keep count lol

    }

    public function broadcastOn(): Channel
    {
        return new Channel('dashboard');
    }
}
