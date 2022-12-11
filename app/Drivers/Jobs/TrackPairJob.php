<?php

namespace App\Drivers\Jobs;

use App\Models\Users\NotifyUser;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Str;

class TrackPairJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 1;
    private string $driver;
    private string $pair;

    /**
     * @param string $driver
     * @param string $pair
     */
    public function __construct(string $driver, string $pair)
    {
        $this->driver = $driver;
        $this->pair = $pair;
    }

    public function handle()
    {
        $instanceOfDriver = app(Str::lower($this->driver));
        $trackedInformation = $instanceOfDriver->trackPair($this->pair);

        if (! $trackedInformation instanceof \App\Models\Drivers\TrackedPair) {
            return;
        }

        $allUsersToNotify = NotifyUser::where('price', '<', $trackedInformation->last_price)->get();

        $allUsersToNotify->each(function (NotifyUser $user) {
            NotifyUserJob::dispatch($user);
        });
    }
}
