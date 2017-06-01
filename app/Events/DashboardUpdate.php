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

    public $totalTweets = 0;
    public $totalUsers = 0;
    public $tweetsPerMinute = 0;
    public $usersWithMostTweets = [];
    public $lastWordOccurrences = [];
    public $processingTime = 0;

    public function __construct()
    {
        // TODO: move to repository
        $startTime = microtime(true);

        $this->totalTweets = Tweet::count();

        $this->totalUsers = User::count();

        $this->tweetsPerMinute = DB::table('tweets')->where('tweeted_at', '>', Carbon::now()->subMinute())->count();

        $this->usersWithMostTweets = Statistics::getUsersWithMostTweets();

        $this->lastWordOccurrences = Statistics::getWordOccurrences(Carbon::parse('30 minutes ago'), 10);

        $this->processingTime = round(microtime(true) - $startTime, 2);
    }

    public function broadcastOn(): Channel
    {
        return new Channel('dashboard');
    }
}
