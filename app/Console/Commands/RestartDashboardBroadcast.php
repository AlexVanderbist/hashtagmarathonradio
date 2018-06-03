<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Console\Command;

class RestartDashboardBroadcast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcast:restart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restart event broadcasting';

    /** @var  CacheRepository */
    protected $cache;

    public function __construct(CacheRepository $cache)
    {
        parent::__construct();

        $this->cache = $cache;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->cache->forever('dashboard:broadcast:restart', Carbon::now()->getTimestamp());

        $this->info('Broadcasting restart signal.');
    }
}
