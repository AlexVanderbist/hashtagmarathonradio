<?php

namespace App\Console;

use App\Console\Commands\BroadcastDashboardEvents;
use App\Console\Commands\CacheDashboardStatistics;
use App\Console\Commands\FetchTweets;
use App\Console\Commands\ListenForTweets;
use App\Console\Commands\RestartDashboardBroadcast;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ListenForTweets::class,
        FetchTweets::class,
        BroadcastDashboardEvents::class,
        RestartDashboardBroadcast::class,
        CacheDashboardStatistics::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(FetchTweets::class)->everyMinute();
        $schedule->command(CacheDashboardStatistics::class)->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
