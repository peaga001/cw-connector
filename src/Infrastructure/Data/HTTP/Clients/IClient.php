<?php

declare(strict_types=1);

namespace CwConnector\Infrastructure\Data\HTTP\Clients;

//HTTPConfigs
use CwConnector\Infrastructure\Data\HTTP\Config\APIConfig;

interface IClient
{
    public static function create(APIConfig $config): self;
    public function authenticate(): self;
    public function token(): ?string;
    public function get(string $uri, array $queryParams = []): array;
    public function post(string $uri, array $body = []): array;
}