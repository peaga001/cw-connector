<?php

declare(strict_types=1);

namespace CwConnector\Application\DTOs\Batch;

//ValueObjects
use CwConnector\Domain\ValueObjects\BatchResult;

class BatchResultDTO
{
    public function __construct(
        private readonly array $result
    ){}

    public static function fromArray($data): self
    {
        return new self(
            result: $data
        );
    }

    public function toEntity(): BatchResult
    {
        return BatchResult::create(
            result: $this->result
        );
    }
}