<?php

declare(strict_types=1);

namespace CwConnector\Tests\src\Application\UseCases;

//ValueObjects
use CwConnector\Domain\ValueObjects\BatchResult;

//UseCases
use CwConnector\Application\UseCases\SendBatchUseCase;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

//Exceptions
use CwConnector\Domain\Exceptions\Batch\BatchSendFailedException;

//Ports
use CwConnector\Domain\Ports\IRepository;

//TestingTools
use CwConnector\Tests\Support\CwTestCase;
use Mockery;

class SendBatchUseCaseTest extends CwTestCase
{
    protected IRepository $repository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(IRepository::class);
    }

    public function test_ShouldBeInstantiateCorrectly(): void
    {
        $useCase = new SendBatchUseCase(
            repository: $this->repository
        );

        $this->assertInstanceOf(SendBatchUseCase::class, $useCase);
    }

    /**
     * @throws BatchSendFailedException
     */
    public function test_ShouldExecute(): void
    {
        $batch = $this->batch(withResult: true);

        $this->repository->shouldReceive('sendBatch')
            ->with($batch)->once()->andReturn($batch);

        $useCase = new SendBatchUseCase(
            repository: $this->repository
        );

        $batchResult = $useCase->execute(batch: $batch);

        $this->assertInstanceOf(BatchResult::class, $batchResult);
    }

    /**
     * @throws BatchSendFailedException
     */
    public function test_ShouldThrowExceptionWhenBatchNotFound(): void
    {
        $this->expectException(BatchSendFailedException::class);
        $this->expectExceptionMessage('Failed to send batch!');
        $this->expectExceptionCode(DomainErrorCodes::BATCH_SEND_FAILED);

        $batch = $this->batch();

        $this->repository->shouldReceive('sendBatch')
            ->with($batch)->once()->andReturn(null);

        $useCase = new SendBatchUseCase(
            repository: $this->repository
        );

        $useCase->execute(batch: $batch);
    }
}