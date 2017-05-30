<?php

namespace App\Console\Commands;

use App\Jobs\ProcessTweet;
use App\Tweet;
use Carbon\Carbon;
use Log;
use Illuminate\Console\Command;
use Spatie\LaravelTwitterStreamingApi\TwitterStreamingApi;

class ListenForTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweets:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen for tweets with the hashtag.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Listening for tweets...');

        $query = config('hmr.stream_query');

        app(TwitterStreamingApi::class)
            ->publicStream()
            ->whenHears([$query], function (array $tweetProperties) {
                if (array_key_exists('limit', $tweetProperties)) {
                    Log::critical('Reached streaming limit. Godspeed to the search API.');

                    return;
                }

                dispatch(new ProcessTweet(collect($tweetProperties)));
            })
            ->startListening();
    }
}
