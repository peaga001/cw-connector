<?php

declare(strict_types=1);

namespace CwConnector\Domain\Entities;

//ValueObjects
use CwConnector\Domain\ValueObjects\BatchResult;

//Enums
use CwConnector\Domain\Enums\BatchStatus;

//Exceptions
use CwConnector\Domain\Exceptions\TimeSheet\InvalidTimeSheetsException;

/**
 * Class Batch
 *
 * Represents a batch containing timesheets, a batch ID, status, and result. Provides functionality
 * to create, modify, and retrieve details about the batch and its associated timesheets. Enforces
 * validation of timesheets to ensure only valid objects are processed as part of the batch.
 */
class Batch
{
    private BatchStatus $batchStatus;
    private BatchResult $batchResult;
    private array $timeSheets;
    private ?string $batchId;

    /**
     * @param TimeSheet[] $timeSheets
     * @param ?string $batchId
     * @param ?BatchStatus $batchStatus
     * @param ?BatchResult $batchResult
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
     * @param TimeSheet[] $timeSheets
     * @param int $batchStatus
     * @param ?BatchResult $batchResult
     * @param ?string $batchId
     * @return self
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

    /**
     * @return TimeSheet[]
     */
    public function timeSheets(): array
    {
        return $this->timeSheets;
    }

    /**
     * @return ?string
     */
    public function batchId(): ?string
    {
        return $this->batchId;
    }

    /**
     * @param string $batchId
     * @return void
     */
    public function setBatchId(string $batchId): void
    {
        $this->batchId = $batchId;
    }

    /**
     * @param BatchStatus $status
     * @return void
     */
    public function setStatus(BatchStatus $status): void
    {
        $this->batchStatus = $status;
    }

    /**
     * @param BatchResult $result
     * @return void
     */
    public function setResult(BatchResult $result): void
    {
        $this->batchResult = $result;
    }

    /**
     * @return BatchStatus
     */
    public function status(): BatchStatus
    {
        return $this->batchStatus;
    }

    /**
     * @return ?BatchResult
     */
    public function result(): ?BatchResult
    {
        return $this->batchResult;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $timeSheets = [];

        foreach ($this->timeSheets as $timeSheet){
            $timeSheets[] = $timeSheet->toArray();
        }

        return [
            'status' => [
                'name' => $this->batchStatus->name,
                'value' => $this->batchStatus->value
            ],
            'result' => $this->batchResult->toArray(),
            'timeSheets' => $timeSheets,
            'batchId' => $this->batchId
        ];
    }

    /**
     * @return void
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