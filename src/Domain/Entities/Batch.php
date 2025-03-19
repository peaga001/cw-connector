<?php

declare(strict_types=1);

namespace Domain\Entities;

use Domain\Enums\BatchStatus;
use Domain\Exceptions\TimeSheet\InvalidTimeSheetsException;

class Batch
{
    private readonly ?string $batchId;
    private readonly BatchStatus $batchStatus;

    /**
     * @param $timeSheets TimeSheet[]
     * @throws InvalidTimeSheetsException
     */
    public function __construct(
        private readonly array $timeSheets
    ){
        $this->checkTimeSheets();

        $this->batchStatus = BatchStatus::CREATED;
        $this->batchId = null;
    }

    /**
     * @throws InvalidTimeSheetsException
     */
    public static function create(array $timeSheets): self
    {
        return new self(
            timeSheets: $timeSheets
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

    public function status(): BatchStatus
    {
        return $this->batchStatus;
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