<?php

declare(strict_types=1);

namespace App\Infrastructure\API\Config;

class APIConfig
{
    public function __construct(
        private readonly string $apiUrl,
        private readonly string $apiKey
    ){}

    public static function create(string $apiUrl, string $apiKey): self
    {
        return new self(
            apiUrl: $apiUrl,
            apiKey: $apiKey
        );
    }

    public function apiUrl(): string
    {
        return $this->apiUrl;
    }

    public function apiKey(): string
    {
        return $this->apiKey;
    }
}