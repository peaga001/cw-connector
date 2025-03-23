<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\FromAPI\Config;

interface IClient
{
    public static function create(APIConfig $config): self;
    public function authenticate(): self;
    public function token(): ?string;
    public function get(string $uri, array $queryParams = []): array;
    public function post(string $uri, array $body = []): array;
    public function put(string $uri, array $body): array;
    public function delete(string $uri, array $body): array;
}