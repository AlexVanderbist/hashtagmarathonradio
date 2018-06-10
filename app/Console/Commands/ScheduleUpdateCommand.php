<?php

namespace App\Console\Commands;

use App\Tweet;
use Illuminate\Console\Command;

class ScheduleUpdateCommand extends Command
{
    protected $signature = 'schedule:update';

    protected $description = 'Command description';

    public function handle()
    {
        $schedule = config('schedule');

        collect($schedule)->each(function (array $period) {
            Tweet::query()
                ->where('dj', -1)
                ->whereBetween('tweeted_at', [$period['start'], $period['stop']])
                ->update(['dj' => $period['id']]);
        });
    }
}
