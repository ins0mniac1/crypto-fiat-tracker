<?php

namespace App\Drivers\Bitfinex;

use App\Drivers\AbstractClient;

class BitfinexClient extends AbstractClient
{
    const TICKER_ENDPOINT = '/pubticker';

    /**
     * reference https://docs.bitfinex.com/v1/reference/rest-public-ticker#rest-public-ticker
     * @param string $pair
     * @return mixed
     */
    protected function ticker(string $pair): mixed
    {
        $endpoint = $this->apiURL . self::V1 . self::TICKER_ENDPOINT . '/' . $pair;

        return json_decode($this->makeCall($endpoint));

    }
}
