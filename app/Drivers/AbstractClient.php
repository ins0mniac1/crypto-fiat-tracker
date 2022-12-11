<?php

namespace App\Drivers;

abstract class AbstractClient
{
    const HTTP_HEADER_FOR_CURL = "accept: application/json";
    const V1 = '/v1';
    const V2 = '/v2';

    const GET_METHOD = 'GET';
    const POST_METHOD = 'POST';

    protected string $apiURL;
    public array $errors = [];

    public function __construct(array $configuration)
    {
        $this->apiURL = $configuration['api_url'];
    }

    abstract protected function ticker(string $pair);

    public function track($pair)
    {
        return $this->ticker($pair);
    }

    protected function makeCall(string $endpoint, array $params = [], string $method = self::GET_METHOD)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                static::HTTP_HEADER_FOR_CURL
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if (!empty($err)) {
            $this->errors[] = $err;
        }

        return $response;
    }
}
