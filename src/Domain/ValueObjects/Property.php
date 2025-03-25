<?php

declare(strict_types=1);

namespace Domain\ValueObjects;

class Property
{
    public function __construct(
        private readonly string $key,
        private readonly mixed $value
    ){}

    public static function create(string $key, mixed $value): self
    {
        return new self(
            key: $key, value: $value
        );
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            $this->key => $this->value
        ];
    }
}