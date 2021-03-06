<?php

namespace App\Console\Commands;

use App\Events\DashboardUpdate;
use App\Jobs\BroadcastDashboardUpdate;
use Illuminate\Cache\Repository;
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

    /** @var  Repository */
    protected $cache;

    public function __construct(Repository $cacheRepository)
    {
        parent::__construct();

        $this->cache = $cacheRepository;
    }

    public function handle()
    {
        $lastRestart = $this->getTimestampOfLastRestart();

        $loop = Factory::create();

        $seconds = 4;

        $loop->addPeriodicTimer($seconds, function () use ($lastRestart, $loop) {
            if ($this->shouldRestart($lastRestart)) {
                $loop->stop();

                $this->info('Received restart signal. Restarting...');

                return;
            }

            $this->info('Broadcasting dashboard update');

            event(new DashboardUpdate());
        });

        $loop->run();
    }

    protected function shouldRestart($lastRestart): bool
    {
        return $this->getTimestampOfLastRestart() != $lastRestart;
    }

    /**
     * Get the last restart timestamp, or null.
     *
     * @return int|null
     */
    protected function getTimestampOfLastRestart()
    {
        if ($this->cache) {
            return $this->cache->get('dashboard:broadcast:restart');
        }
    }
}
