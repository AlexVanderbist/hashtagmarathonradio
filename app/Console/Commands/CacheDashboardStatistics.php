<?php

namespace App\Console\Commands;

use App\Repositories\Statistics;
use Illuminate\Console\Command;

class CacheDashboardStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and cache some heavy dashboard stats.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->cacheUsersWithMostTweets();

        $this->cacheAllTimeWordOccurrences();
    }

    protected function cacheUsersWithMostTweets()
    {
        $this->info('Started calculating users with most tweets');

        Statistics::cacheUsersWithMostTweets();

        $this->info('Users with most tweets cached');
    }

    protected function cacheAllTimeWordOccurrences()
    {
        $this->info('Started calculating word occurrences');

        Statistics::cacheAllTimeWordOccurrences();

        $this->info('All time word occurrences cached');
    }
}
