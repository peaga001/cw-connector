<?php

declare(strict_types=1);

namespace CwConnector\Infrastructure\Data\HTTP\Config;

/**
 * Represents the configuration required to interact with an API.
 * This includes the base URL of the API and the API key for authentication.
 */
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