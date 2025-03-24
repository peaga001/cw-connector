<?php

namespace Domain\ValueObjects;

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