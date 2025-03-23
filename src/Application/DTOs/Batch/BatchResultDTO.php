<?php

declare(strict_types=1);

namespace App\Application\DTOs\Batch;

use Domain\ValueObjects\BatchResult\BatchResult;

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
            results: $this->result
        );
    }
}