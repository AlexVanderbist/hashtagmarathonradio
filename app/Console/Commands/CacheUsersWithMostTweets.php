<?php

namespace App\Console\Commands;

use App\Repositories\Statistics;
use Illuminate\Console\Command;

class CacheUsersWithMostTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'highscores:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and cache new highscores.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Started calculating users with most tweets');

        Statistics::cacheUsersWithMostTweets();

        $this->info('Users with most tweets updated');
    }
}
