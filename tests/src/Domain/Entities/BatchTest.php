<?php

namespace Tests\src\Domain\Entities;

//Entities
use Domain\Entities\Batch;

//Enums
use Domain\Enums\BatchStatus;

//ErrorCodes
use Domain\ErrorCodes\DomainErrorCodes;

//Exceptions
use Domain\Exceptions\TimeSheet\InvalidTimeSheetsException;

//TestingTools
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
    public function test_ShouldReturnBatchStatusDefinedAfterInsertingBatchStatus(): void
    {
        $batchStatus = BatchStatus::FAILED;
        $batch = Batch::create(
            timeSheets: $this->timeSheets()
        );

        $this->assertEquals(BatchStatus::CREATED, $batch->status());

        $batch->setStatus($batchStatus);
        $this->assertEquals($batchStatus, $batch->status());
    }

    /**
     * @throws InvalidTimeSheetsException
     */
    public function test_ShouldReturnTheValuesCorrectlyWhenCallingToArray(): void
    {
        $batch = Batch::create(
            timeSheets: $this->timeSheets(quantity: 1)
        );

        $batchInArray = $batch->toArray();

        $this->assertEquals($batch->status(), BatchStatus::tryFrom($batchInArray['status']['value']));
        $this->assertEquals($batch->result()->toArray(), $batchInArray['result']);
        $this->assertEquals($batch->timeSheets()[0]->toArray(), $batchInArray['timeSheets'][0]);
        $this->assertNull($batchInArray['batchId']);
    }

}