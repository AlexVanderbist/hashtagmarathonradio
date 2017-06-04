<?php

namespace App\Console\Commands;

use App\Jobs\ProcessTweet;
use App\Tweet;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Twitter;

class FetchTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweets:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch tweets with the hashtag.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Set query for easy access
        $query = config('hmr.search_query');

        // Maximum id that will be retrieved now; Lowest tweet id we retrieved last time
        $maxId = null;

        // Have we started retrieving tweets that are already in the db?
        $reachedOldTweets = false;

        // Retreive last loaded tweet in db
        $highestTweetId = Tweet::where('fetched', true)->max('id');

        // If there are no tweets in the database; set the value to 0
        $highestTweetId = ($highestTweetId == null ? 0 : $highestTweetId);
        $this->info("Highest Tweet ID in the database: $highestTweetId");

        // HMR start date
        $startDate = new Carbon(config('hmr.start_time'));

        // Count the amount of tweets we're loading this time the command is called
        $numTweetsPostedThisSchedule = 0;
        $numApiCallsThisSchedule = 0;

        while (! $reachedOldTweets) {
            // fetch tweets by certain query where id < maxId (lowest id from last batch)
            // Use 'since_id' => TWEETID to limit tweet id > since_id
            $tweets = Twitter::getSearch(['q' => $query, 'count' => 100, 'max_id' => $maxId]);
            $numApiCallsThisSchedule ++;

            $numTweets = count($tweets->statuses);
            $this->info("\n\nLoaded {$numTweets} Tweets (maxId = {$maxId}).");

            // check for no results or api error
            if(empty($tweets->statuses)) {
                break;
            }

            $bar = $this->output->createProgressBar($numTweets);

            // loop through tweets
            $tweets = collect($tweets->statuses)
                ->each(function ($tweet) use ($highestTweetId, $startDate, &$numTweetsPostedThisSchedule, $bar, &$reachedOldTweets) {

                    $tweetedAt = new Carbon($tweet->created_at);
                    $tweetedAt->setTimezone('Europe/Brussels');

                    // Check if we've reached old tweets or the start of hmr
                    if($tweet->id <= $highestTweetId) { // TODO : || $tweetedAt->lt($startDate)) {
                        $reachedOldTweets = true;

                        return false;
                    }

                    $tweet->fetched = true;

                    $tweet = json_decode(json_encode($tweet), true);

                    dispatch(new ProcessTweet(collect($tweet)));

                    $numTweetsPostedThisSchedule++;
                    $bar->advance();
                });

            $maxId = $tweets->min('id') - 1;

            $bar->finish();

            // Check if we're nearing API rate limits (180/15min)
            if($numApiCallsThisSchedule == 100) {
                $this->warn("\n\nUsed 100 API calls, stopped loading tweets to keep API open. (Nearing rate limit)");
                break;
            }
        }

        // Do this as long as we don't reach old tweets or Twitter starts returning empty responses (rate limit)
        if($reachedOldTweets) {
            $this->info("\n\nReached old tweets after $numTweetsPostedThisSchedule tweets!");
        }

        $this->info("\nLoaded $numTweetsPostedThisSchedule Tweets to the database in $numApiCallsThisSchedule API calls to Twitter!");
    }
}
