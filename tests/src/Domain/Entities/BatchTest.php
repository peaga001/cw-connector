<?php

namespace Tests\src\Domain\Entities;

use Domain\Entities\Batch;
use Domain\Enums\BatchStatus;
use Domain\ErrorCodes\DomainErrorCodes;
use Domain\Exceptions\TimeSheet\InvalidTimeSheetsException;
use Tests\Support\CwTestCase;

class BatchTest extends CwTestCase
{
    /**
     * @throws InvalidTimeSheetsException
     */
    public function test_ShouldBeInstantiateBatchFromConstructor(): void
    {
        $batch = new Batch(
            timeSheets: $this->timeSheets()
        );

        $this->assertInstanceOf(Batch::class, $batch);
    }

    /**
     * @throws InvalidTimeSheetsException
     */
    public function test_ShouldBeInstantiateBatchFromStaticFunction(): void
    {
        $batch = Batch::create(
            timeSheets: $this->timeSheets()
        );

        $this->assertInstanceOf(Batch::class, $batch);
    }

    public function test_ThrowExceptionWhenTryInstantiateBatchWithInvalidTimeSheets(): void
    {
        $this->expectException(InvalidTimeSheetsException::class);
        $this->expectExceptionMessage('Time sheets is invalid!');
        $this->expectExceptionCode(DomainErrorCodes::TIME_SHEET_INVALID_TIME_SHEETS);

        $timeSheets = $this->timeSheets();
        $timeSheets[] = 'invalid time sheet';
        $timeSheets[] = [$this->timeEntries(), $this->personId()];

        Batch::create(
            timeSheets: $timeSheets
        );
    }

    /**
     * @throws InvalidTimeSheetsException
     */
    public function test_ShouldReturnCreatedStatusAfterCreatingBatch(): void
    {
        $batch = Batch::create(
            timeSheets: $this->timeSheets()
        );

        $this->assertEquals(BatchStatus::CREATED, $batch->status());
    }

    /**
     * @throws InvalidTimeSheetsException
     */
    public function test_ShouldReturnTimeSheets(): void
    {
        $timeSheets = $this->timeSheets();

        $batch = Batch::create(
            timeSheets: $timeSheets
        );

        $this->assertEquals($timeSheets, $batch->timeSheets());
    }


    /**
     * @throws InvalidTimeSheetsException
     */
    public function test_ShouldReturnNullOnBatchIdAfterCreatingBatch(): void
    {
        $batch = Batch::create(
            timeSheets: $this->timeSheets()
        );

        $this->assertNull($batch->batchId());
    }

    /**
     * @throws InvalidTimeSheetsException
     */
    public function test_ShouldReturnBatchIdDefinedAfterInsertingBatchId(): void
    {
        $batchId = $this->batchId();

        $batch = Batch::create(
            timeSheets: $this->timeSheets()
        );

        $this->assertNull($batch->batchId());

        $batch->setBatchId($batchId);
        $this->assertEquals($batchId, $batch->batchId());
    }

    /**
     * @throws InvalidTimeSheetsException
     */
    public function test_ShouldReturnBatchStatusDefinedAfterInsertingBatchStatus()
    {
        $batchStatus = BatchStatus::FAILED;
        $batch = Batch::create(
            timeSheets: $this->timeSheets()
        );

        $this->assertEquals(BatchStatus::CREATED, $batch->status());

        $batch->setStatus($batchStatus);
        $this->assertEquals($batchStatus, $batch->status());
    }
}