<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\FromAPI\Clients;

use App\Infrastructure\Data\FromAPI\Config\APIConfig;
use App\Infrastructure\Data\FromAPI\Config\IClient;
use App\Infrastructure\Data\FromAPI\Config\Routes;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;
use Exception;

class Guzzle implements IClient
{
    public Client $client;
    private ?string $token = null;
    private ?string $apiKey;

    public function __construct(
        APIConfig $config
    ){
        $this->client = new Client(config:[
            'base_uri' => $config->baseUrl()
        ]);

        $this->apiKey = $config->apiKey();
    }

    public static function create(APIConfig $config): self
    {
        return new self($config);
    }

    /**
     * @throws Exception
     * @throws GuzzleException
     */
    public function authenticate(): self
    {
        $response = $this->client->post(uri: Routes::AUTHENTICATE, options: [
            'body' => [
                'api_key' => $this->apiKey
            ]
        ]);

        $bodyContent = $this->bodyContent($response);

        if(!isset($bodyContent['token'])){
            throw new Exception('Token not found');
        }

        $this->token = $bodyContent['token'];

        return $this;
    }

    /**
     * @throws GuzzleException
     */
    public function token(): ?string
    {
        if(is_null($this->token)) {
            $this->authenticate();
        }

        return $this->token;
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $uri, array $queryParams = []): array
    {
        $response = $this->client->get(uri: $uri, options: [
            'headers' => $this->headers(),
            'query' => $queryParams
        ]);

        return $this->bodyContent($response);
    }

    /**
     * @throws GuzzleException
     */
    public function post(string $uri, array $body = []): array
    {
        $response = $this->client->post(uri: $uri, options: [
            'headers' => $this->headers(),
            'body' => $body
        ]);

        return $this->bodyContent($response);
    }

    /**
     * @throws GuzzleException
     */
    public function put(string $uri, array $body): array
    {
        $response = $this->client->put(uri: $uri, options: [
            'headers' => $this->headers(),
            'body' => $body
        ]);

        return $this->bodyContent($response);
    }

    /**
     * @throws GuzzleException
     */
    public function delete(string $uri, array $body): array
    {
        $response = $this->client->delete(uri: $uri, options: [
            'headers' => $this->headers(),
            'body' => $body
        ]);

        return $this->bodyContent($response);
    }

    /**
     * @throws GuzzleException
     */
    private function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token(),
            'Content-Type' => 'application/json'
        ];
    }

    private function bodyContent(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}