<?php

namespace App\Console\Commands;

use App\Events\DashboardUpdate;
use Illuminate\Console\Command;
use React\EventLoop\Factory;

class BroadcastDashboardEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:broadcast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Broadcast every 5 seconds to the dashboard';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $loop = Factory::create();

        $seconds = 5;

        $loop->addPeriodicTimer($seconds, function () {
            echo "Tick\n";
            event(new DashboardUpdate());
        });

        $loop->run();
    }
}
