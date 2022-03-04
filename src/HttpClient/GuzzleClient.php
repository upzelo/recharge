<?php

declare(strict_types=1);

namespace Recharge\HttpClient;

use GuzzleHttp\Client;
use Recharge\Contracts\HttpClient\ClientInterface;

class GuzzleClient implements ClientInterface
{
    protected static ?GuzzleClient $instance = null;

    protected Client $client;

    public function __construct(array $options = [])
    {
        $this->client = new Client($options);
    }

    public static function instance(): GuzzleClient
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return static::$instance;
    }

    public function request(string $method, string $url, array $headers = [], array $params = []): array
    {
        $response = match ($method) {
            'get' => $this->getRequest($url, $headers, $params),
            default => $this->getRequest($url, $headers, $params),
        };

        return [
            $response->getBody()->getContents(),
            $response->getStatusCode(),
            $response->getHeaders(),
        ];
    }

    public function getRequest(string $url, array $headers = [], array $params = []): \Psr\Http\Message\ResponseInterface
    {
        return $this->client->get($url, ['query' => $params, 'headers' => $headers]);
    }
}
