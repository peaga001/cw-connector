<?php

namespace App\Application\DTOs\Batch;

use App\Application\DTOs\TimeSheet\TimeSheetDTO;
use App\Domain\Exceptions\DomainException;
use Domain\Entities\Batch;

class BatchDTO
{
    public function __construct(
        private readonly array $timeSheets = [],
        private readonly BatchResultDTO $batchResult,
        private readonly string $batchId = '',
        private readonly ?int $status = null
    ){}

    /**
     * @throws DomainException
     */
    public static function fromArray(array $data): self
    {
        $timeSheets = [];

        foreach ($data['timeSheets'] as $timeSheet) {
            $timeSheets[] = TimeSheetDTO::fromArray($timeSheet)->toEntity();
        }

        return new self(
            timeSheets: $timeSheets,
            batchResult: BatchResultDTO::fromArray($data['batchResult']),
        );
    }

    /**
     * @throws DomainException
     */
    public function toEntity(): ?Batch
    {
        return Batch::create(
            timeSheets: $this->timeSheets,
            batchStatus: $this->status,
            batchResult: $this->batchResult->toEntity(),
            batchId: $this->batchId
        );
    }
}