<?php

return [
    'api_url' => env('BITFINEX_API', 'https://api.bitfinex.com/'),
    'client' => \App\Drivers\Bitfinex\BitfinexClient::class,
];
