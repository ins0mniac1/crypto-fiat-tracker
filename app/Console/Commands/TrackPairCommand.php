<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TrackPairCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'track-pairs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track pairs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $allDrivers = config('trackable_drivers.tracked_drivers');
        $allPairs = config('trackable_drivers.tracked_pairs');

        foreach ($allDrivers as $driver) {
            foreach (array_keys($allPairs) as $pair) {
                \App\Drivers\Jobs\TrackPairJob::dispatch($driver, $pair);
            }
        }

        return Command::SUCCESS;
    }
}
