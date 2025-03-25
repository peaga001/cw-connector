<?php

declare(strict_types=1);

namespace CwConnector\Infrastructure\Data\HTTP\Clients;

//HTTPConfigs
use CwConnector\Infrastructure\Data\HTTP\Config\APIConfig;
use CwConnector\Infrastructure\Data\HTTP\Config\Routes;

//Exceptions
use CwConnector\Infrastructure\Data\HTTP\Exceptions\UnauthorizedException;

//GuzzleTools
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;


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
     * @throws UnauthorizedException
     * @throws GuzzleException
     */
    public function authenticate(): self
    {
        $response = $this->client->post(uri: Routes::AUTHENTICATE, options: [
            'form_params' => [
                'api_key' => $this->apiKey
            ]
        ]);

        $bodyContent = $this->bodyContent($response);

        if(!isset($bodyContent['token'])){
            throw new UnauthorizedException;
        }

        $this->token = $bodyContent['token'];

        return $this;
    }

    /**
     * @throws GuzzleException
     * @throws UnauthorizedException
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
     * @throws UnauthorizedException
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
     * @throws UnauthorizedException
     */
    public function post(string $uri, array $body = []): array
    {
        $response = $this->client->post(uri: $uri, options: [
            'headers' => $this->headers(),
            'form_params' => $body
        ]);

        return $this->bodyContent($response);
    }

    /**
     * @throws GuzzleException
     * @throws UnauthorizedException
     */
    private function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token(),
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
    }

    private function bodyContent(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}