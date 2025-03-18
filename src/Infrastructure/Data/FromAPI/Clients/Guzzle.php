<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\FromAPI\Clients;

use App\Infrastructure\Data\FromAPI\Config\APIConfig;
use App\Infrastructure\Data\FromAPI\Config\IClient;
use App\Infrastructure\Data\FromAPI\Config\Routes;
use Guzzle\Http\Client;

class Guzzle extends Client implements IClient
{
    private ?string $token = null;
    public function __construct(
        APIConfig $config
    ){
        parent::__construct($config->baseUrl());
    }

    public static function create(APIConfig $config): self
    {
        return new self($config);
    }

    public function authenticate(): self
    {
        $response = $this->post(
            uri: Routes::AUTHENTICATE,
            headers: []
        )->send()->getBody();


        if(trim($response['token'])){
            $this->token = $response['token'];
        }

        return $this;
    }

    public function token(): ?string
    {
        return $this->token;
    }
}