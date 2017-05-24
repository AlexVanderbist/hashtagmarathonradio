<?php

namespace App\Jobs;

use App\Tweet;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use Log;

class ProcessTweet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var  \Illuminate\Support\Collection */
    protected $tweet;

    public function __construct(Collection $tweetProperties)
    {
        $this->tweet = $tweetProperties;
    }

    public function handle()
    {

        $formattedTweetedAt = Carbon::parse($this->tweet['created_at']);
        $formattedTweetedAt->setTimezone('Europe/Brussels');

        Tweet::firstOrCreate(
            ['id' => $this->tweet['id']],
            [
                'user_id' => $this->tweet['user']['id'],
                'tweet' => $this->tweet['text'],
                'tweeted_at' => $formattedTweetedAt,
                'fetched' => $this->tweet['fetched'] || false,
                'dj' => -1
            ]
        )->save();
    }
}
