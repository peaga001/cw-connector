<?php

declare(strict_types=1);

namespace CwConnector\Tests\src\Manager;

//Enums
use CwConnector\Domain\Enums\BatchStatus;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;


//Exceptions
use CwConnector\Domain\Exceptions\Batch\BatchNotFoundException;
use CwConnector\Domain\Exceptions\Batch\BatchSendFailedException;
use CwConnector\Domain\Exceptions\Batch\BatchSendInBackgroundFailedException;
use CwConnector\Domain\Exceptions\Batch\UnfinishedBatchException;

//Ports
use CwConnector\Application\Ports\ITranslator;
use CwConnector\Domain\Ports\IRepository;

//Manager
use CwConnector\Manager\ClockWiseManager;

//TestingTools
use CwConnector\Tests\Support\CwTestCase;
use Mockery;

class ClockWiseManagerTest extends CwTestCase
{
    private readonly ITranslator $translator;
    private readonly IRepository $repository;
    public function setUp(): void
    {
        parent::setUp();

        $this->repository = Mockery::mock(IRepository::class);
        $this->translator = Mockery::mock(ITranslator::class);
    }

    public function test_ShouldBeInstantiateClockWiseManager(): void
    {
        $CWManager = new ClockWiseManager(
            repository: $this->repository,
            translator: $this->translator
        );

        $this->assertInstanceOf(ClockWiseManager::class, $CWManager);
    }

    /**
     * @throws UnfinishedBatchException
     * @throws BatchNotFoundException
     */
    public function test_ShouldBeExecuteGetResults(): void
    {
        $expectedResult = ['success' => true];

        $batch = $this->batch(withId: true, withResult: true);
        $batch->setStatus(BatchStatus::FINISHED);

        $batchId = $batch->batchId();
        $batchResult = $batch->result();

        $CWManager = new ClockWiseManager(
            repository: $this->repository,
            translator: $this->translator
        );

        $this->repository
            ->shouldReceive('getById')
            ->with($batchId)
            ->andReturn($batch);

        $this->repository
            ->shouldReceive('getBatchResult')
            ->with($batchId)
            ->andReturn($batch);

        $this->translator
            ->shouldReceive('translate')
            ->with($batchResult->toArray())
            ->andReturn($expectedResult);

        $result = $CWManager->getResults($batchId);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @throws UnfinishedBatchException
     * @throws BatchNotFoundException
     */
    public function test_ShouldThrowUnfinishedBatchExceptionWhenGetResults(): void
    {
        $this->expectException(UnfinishedBatchException::class);
        $this->expectExceptionMessage('Batch is not finished!');
        $this->expectExceptionCode(DomainErrorCodes::BATCH_UNFINISHED_BATCH);

        $batch = $this->batch(withId: true);
        $batchId = $batch->batchId();

        $CWManager = new ClockWiseManager(
            repository: $this->repository,
            translator: $this->translator
        );

        $this->repository
            ->shouldReceive('getById')
            ->with($batchId)
            ->andReturn($batch);

        $CWManager->getResults($batchId);
    }

    /**
     * @throws UnfinishedBatchException
     * @throws BatchNotFoundException
     */
    public function test_ShouldThrowBatchNotFoundExceptionWhenGetResults(): void
    {
        $this->expectException(BatchNotFoundException::class);
        $this->expectExceptionMessage('Batch not found!');
        $this->expectExceptionCode(DomainErrorCodes::BATCH_NOT_FOUND_EXCEPTION);

        $batchId = $this->batchId();

        $CWManager = new ClockWiseManager(
            repository: $this->repository,
            translator: $this->translator
        );

        $this->repository
            ->shouldReceive('getById')
            ->with($batchId)
            ->andReturn(null);

        $CWManager->getResults($batchId);
    }

    /**
     * @throws BatchNotFoundException
     */
    public function test_ShouldBeExecuteGetStatus(): void
    {
        $batch = $this->batch(withId: true);
        $batchId = $batch->batchId();
        $batch->setStatus(BatchStatus::FAILED);

        $CWManager = new ClockWiseManager(
            repository: $this->repository,
            translator: $this->translator
        );

        $this->repository
            ->shouldReceive('getById')
            ->with($batchId)
            ->andReturn($batch);

        $status = $CWManager->getCurrentStatus($batchId);

        $this->assertEquals($batch->status()->value, $status);
    }

    /**
     * @throws BatchNotFoundException
     */
    public function test_ShouldThrowBatchNotFoundExceptionWhenGetStatus()
    {
        $this->expectException(BatchNotFoundException::class);
        $this->expectExceptionMessage('Batch not found!');
        $this->expectExceptionCode(DomainErrorCodes::BATCH_NOT_FOUND_EXCEPTION);

        $batchId = $this->batchId();

        $CWManager = new ClockWiseManager(
            repository: $this->repository,
            translator: $this->translator
        );

        $this->repository
            ->shouldReceive('getById')
            ->with($batchId)
            ->andReturn(null);

        $CWManager->getCurrentStatus($batchId);
    }

    /**
     * @throws BatchSendFailedException
     */
    public function test_ShouldBeExecuteSendBatch(): void
    {
        $expectedResult = ['success' => true];

        $batch = $this->batch(withResult: true);

        $CWManager = new ClockWiseManager(
            repository: $this->repository,
            translator: $this->translator
        );

        $this->repository
            ->shouldReceive('sendBatch')
            ->with($batch)
            ->andReturn($batch);

        $this->translator
            ->shouldReceive('translate')
            ->with($batch->result()->toArray())
            ->andReturn($expectedResult);

        $result = $CWManager->send($batch);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @throws BatchSendFailedException
     */
    public function test_ShouldThrowBatchSendFailedExceptionWhenSendBatch(): void
    {
        $this->expectException(BatchSendFailedException::class);
        $this->expectExceptionMessage('Failed to send batch!');
        $this->expectExceptionCode(DomainErrorCodes::BATCH_SEND_FAILED);

        $batch = $this->batch();

        $CWManager = new ClockWiseManager(
            repository: $this->repository,
            translator: $this->translator
        );

        $this->repository
            ->shouldReceive('sendBatch')
            ->with($batch)
            ->andReturn(null);

        $CWManager->send($batch);
    }

    /**
     * @throws BatchSendInBackgroundFailedException
     */
    public function test_ShouldBeExecuteSendBatchInBackground(): void
    {
        $batch = $this->batch(withId: true);

        $CWManager = new ClockWiseManager(
            repository: $this->repository,
            translator: $this->translator
        );

        $this->repository
            ->shouldReceive('sendBatchInBackground')
            ->with($batch)
            ->andReturn($batch);


        $batchId = $CWManager->sendInBackground($batch);

        $this->assertEquals($batch->batchId(), $batchId);
    }

    /**
     * @throws BatchSendInBackgroundFailedException
     */
    public function test_ShouldThrowBatchSendInBackgroundFailedException(): void
    {
        $this->expectException(BatchSendInBackgroundFailedException::class);
        $this->expectExceptionMessage('Failed to send batch in background!');
        $this->expectExceptionCode(DomainErrorCodes::BATCH_SEND_IN_BACKGROUND_FAILED);

        $batch = $this->batch();

        $CWManager = new ClockWiseManager(
            repository: $this->repository,
            translator: $this->translator
        );

        $this->repository
            ->shouldReceive('sendBatchInBackground')
            ->with($batch)
            ->andReturn(null);

        $CWManager->sendInBackground($batch);
    }
}