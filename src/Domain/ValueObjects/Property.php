<?php

declare(strict_types=1);

namespace CwConnector\Domain\ValueObjects;

/**
 * Represents a property with a key-value pair.
 *
 * This class encapsulates a key and its corresponding value and provides
 * methods to interact with them, such as retrieving the key, value, or
 * converting the property to an associative array.
 */
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
}