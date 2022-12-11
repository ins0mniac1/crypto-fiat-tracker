<?php

namespace App\Drivers\Bitfinex;

use App\Drivers\AbstractDriver;

class Bitfinex extends AbstractDriver
{
    public function trackPair(string $pair = 'BTCUSD')
    {
        try {
            $response = $this->client->track($pair);
        } catch (\Exception $exception) {
            return  $this->recordFailCall([$exception->getMessage()], __FUNCTION__);
        }

        if (!empty($this->client->errors)) {
            return $this->recordFailCall($this->client->errors, __FUNCTION__);
        }

        if (!isset($response->last_price)) {
            return $this->recordFailCall($response, __FUNCTION__);
        }

        return $this->record($pair, $response->last_price, $response->low, $response->high);
    }
}
