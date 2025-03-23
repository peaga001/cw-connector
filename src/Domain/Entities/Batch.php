<?php

declare(strict_types=1);

namespace Domain\Entities;

use Domain\ValueObjects\BatchResult\BatchResult;
use Domain\Enums\BatchStatus;
use Domain\Exceptions\TimeSheet\InvalidTimeSheetsException;

class Batch
{
    private BatchStatus $batchStatus;
    private BatchResult $batchResult;
    private array $timeSheets;
    private ?string $batchId;

    /**
     * @param $timeSheets TimeSheet[]
     * @throws InvalidTimeSheetsException
     */
    public function __construct(
        array $timeSheets,
        ?string $batchId = null,
        ?BatchStatus $batchStatus = null,
        ?BatchResult $batchResult = null
    ){
        $this->batchStatus = $batchStatus ?? BatchStatus::CREATED;
        $this->batchResult = $batchResult ?? BatchResult::create([]);
        $this->timeSheets = $timeSheets;
        $this->batchId = $batchId;

        $this->checkTimeSheets();
    }

    /**
     * @throws InvalidTimeSheetsException
     */
    public static function create(
        array $timeSheets,
        int $batchStatus = BatchStatus::CREATED->value,
        BatchResult $batchResult = null,
        string $batchId = null,
    ): self
    {
        return new self(
            timeSheets: $timeSheets,
            batchId: $batchId,
            batchStatus: $batchStatus ? BatchStatus::tryFrom($batchStatus) : BatchStatus::CREATED,
            batchResult: $batchResult
        );
    }

    public function timeSheets(): array
    {
        return $this->timeSheets;
    }

    public function batchId(): ?string
    {
        return $this->batchId;
    }

    public function setBatchId(string $batchId): void
    {
        $this->batchId = $batchId;
    }

    public function setStatus(BatchStatus $status): void
    {
        $this->batchStatus = $status;
    }

    public function setResult(BatchResult $result): void
    {
        $this->batchResult = $result;
    }

    public function status(): BatchStatus
    {
        return $this->batchStatus;
    }

    public function result(): ?BatchResult
    {
        return $this->batchResult;
    }

    /**
     * @throws InvalidTimeSheetsException
     */
    private function checkTimeSheets(): void
    {
        foreach ($this->timeSheets as $timeSheet){

            $isTimeSheet = $timeSheet instanceof TimeSheet;

            if(!$isTimeSheet){
                throw new InvalidTimeSheetsException;
            }
        }
    }
}