<?php

declare(strict_types=1);

namespace Infrastructure\Data\HTTP\Config;

class APIConfig
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiKey
    ){}

    public static function create(string $baseUrl, string $apiKey): self
    {
        return new self($baseUrl, $apiKey);
    }
    public function baseUrl(): string
    {
        return $this->baseUrl;
    }

    public function apiKey(): string
    {
        return $this->apiKey;
    }
}