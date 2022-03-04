<?php

declare(strict_types=1);

namespace Recharge;

use GuzzleHttp\Client;

class ApiRequestor
{
    private static ?Client $httpClient = null;

    public function __construct(private string $apiKey, private string $apiBase)
    {
    }

    public function request($method, $url, $params = null, $headers = null)
    {
        $params = $params ?: [];
        $headers = $headers ?: [];

        self::$httpClient = new Client([
            'base_uri' => $this->apiBase,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Recharge-Version' => '2021-11',
            ],
        ]);

        $response = match ($method) {
            'post' => $this->httpClient()->post($url, ['json' => $params]),
            default => $this->httpClient()->get($url, ['query' => $params]),
        };

        $body = $response->getBody()->getContents();

        return new ApiResponse(
            $response->getHeaders(),
            $body,
            json_decode($body, true),
            $response->getStatusCode()
        );
    }

    private function httpClient(): Client
    {
        if (!self::$httpClient) {
            self::$httpClient = new Client([
                'base_uri' => $this->apiBase,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-Recharge-Version' => '2021-11',
                ],
            ]);
        }

        return self::$httpClient;
    }
}
