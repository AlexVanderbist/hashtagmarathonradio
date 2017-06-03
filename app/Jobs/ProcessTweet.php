<?php

namespace App\Jobs;

use App\Tweet;
use App\User;
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

        User::firstOrCreate(
            ['id' => $this->tweet['user']['id']],
            [
                'name' => $this->tweet['user']['name'],
                'screen_name' => $this->tweet['user']['screen_name'],
                'profile_image_url' => $this->tweet['user']['profile_image_url'],
            ]
        );

        Tweet::updateOrCreate(
            ['id' => $this->tweet['id']],
            [
                'user_id' => $this->tweet['user']['id'],
                'text' => $this->tweet['text'],
                'reply_to_id' => $this->tweet['in_reply_to_status_id'],
                'retweeted_id' => $this->tweet['retweeted_status']['id'] ?? null,
                'country_code' => $this->tweet['place']['country_code'] ?? null,
                'place_name' => $this->tweet['place']['full_name'] ?? null,
                'fetched' => $this->tweet['fetched'] ?? false,
                'dj' => getCurrentDjId(),
                'tweeted_at' => $formattedTweetedAt,
            ]
        )->save();
    }
}
