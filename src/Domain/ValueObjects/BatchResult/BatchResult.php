<?php

namespace Domain\ValueObjects\BatchResult;

class BatchResult
{
    public function __construct(
        private array $results = []
    ){}

    public static function create(array $results): self
    {
        return new self(
            results: $results
        );
    }

    public function data(): array
    {
        return $this->results;
    }

    public function setData(array $results): void
    {
        $this->results = $results;
    }
}