<?php

namespace App\Drivers;

use App\Models\Drivers\FailCall;
use App\Models\Drivers\TrackedPair;
use Illuminate\Support\Str;

abstract class AbstractDriver
{
    protected AbstractClient $client;

    public function __construct()
    {
        $this->loadClient();
    }

    abstract public function trackPair(string $pair = 'BTCUSD');

    protected function record(string $pair, float $lastPrice, ?float $lowPrice = null, ?float $highPrice = null)
    {
        return TrackedPair::create(
            [
                'driver' => static::class,
                'pair' => $pair,
                'last_price' => $lastPrice,
                'low_price' => $lowPrice,
                'high_price' => $highPrice,
            ]
        );
    }

    protected function recordFailCall(array $errors, string $method)
    {
        return FailCall::create(
            [
                'driver' => static::class,
                'method' => $method,
                'errors' => json_encode($errors)
            ]
        );
    }

    private function loadClient()
    {
        $classNamespace = explode('\\', static::class);
        $configFile = config(Str::lower(end($classNamespace)));
        $this->client = new $configFile['client']($configFile);
    }
}
