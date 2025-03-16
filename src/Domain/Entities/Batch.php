<?php

declare(strict_types=1);

namespace Domain\Entities;

use Domain\Enums\BatchStatus;

class Batch
{
    /**
     * @param $timeSheets TimeSheet[]
     */
    public function __construct(
        private readonly ?string $batchId = null,
        private readonly array $timeSheets,
        private readonly BatchStatus $batchStatus
    ){}

    public static function create(array $timeSheets): self
    {
        return new self(
            timeSheets: $timeSheets,
            batchStatus: BatchStatus::CREATED
        );
    }

    public function timeSheets(): array
    {
        return $this->timeSheets;
    }

    public function batchId(): string
    {
        return $this->batchId;
    }

    public function status(): BatchStatus
    {
        return $this->batchStatus;
    }
}