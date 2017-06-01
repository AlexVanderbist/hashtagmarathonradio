<?php

namespace App\Events;

use App\Repositories\Statistics;
use App\Tweet;
use App\User;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Cache;
use DB;

class DashboardUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $totalTweets = 0;
    public $totalUsers = 0;
    public $tweetsPerMinute = 0;
    public $usersWithMostTweets = [];
    public $lastWordOccurrences = [];

    public function __construct()
    {
        // TODO: move to repository

        $startTime = microtime(true);

        $this->totalTweets = Tweet::all()->count();

        $this->totalUsers = User::all()->count();

        $this->tweetsPerMinute = Tweet::where('tweeted_at', '>', Carbon::now()->subMinute())->count();

        $this->usersWithMostTweets =  DB::table('users')
                ->select('users.*', DB::raw('count(*) as tweets_count'))
                ->join('tweets', 'users.id', 'tweets.user_id')
                ->groupBy('id')
                ->orderBy('tweets_count', 'desc')
                ->limit(50)
                ->get();

        $this->lastWordOccurrences = Statistics::getWordOccurrences(Carbon::parse('30 minutes ago'), 10);

        echo 'Processing time: ' . (microtime(true) - $startTime) . "\n";
    }

    public function broadcastOn(): Channel
    {
        return new Channel('dashboard');
    }
}
