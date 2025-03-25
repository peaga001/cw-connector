<?php

declare(strict_types=1);

namespace CwConnector\Domain\ValueObjects;

/**
 * Represents the result of a batch operation, encapsulating an array of results.
 */
class BatchResult
{
    public function __construct(
        private readonly array $result = []
    ){}

    public static function create(array $result): self
    {
        return new self(
            result: $result
        );
    }

    public function toArray(): array
    {
        return $this->result;
    }
}