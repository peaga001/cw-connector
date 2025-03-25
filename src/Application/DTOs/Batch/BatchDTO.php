<?php

declare(strict_types=1);

namespace CwConnector\Application\DTOs\Batch;

//DTOs
use CwConnector\Application\DTOs\TimeSheet\TimeSheetDTO;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//Entities
use CwConnector\Domain\Entities\Batch;

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

        foreach ($data['time_sheets'] as $timeSheet) {
            $timeSheets[] = TimeSheetDTO::fromArray($timeSheet)->toEntity();
        }

        return new self(
            timeSheets: $timeSheets,
            batchResult: BatchResultDTO::fromArray($data['result']),
            batchId: $data['batch_id'] ?? '',
            status: $data['status']
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