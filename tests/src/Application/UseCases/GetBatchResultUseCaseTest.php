<?php

declare(strict_types=1);

namespace CwConnector\Tests\src\Application\UseCases;

//ValueObjects
use CwConnector\Domain\ValueObjects\BatchResult;

//UseCases
use CwConnector\Application\UseCases\GetBatchResultUseCase;

//Enums
use CwConnector\Domain\Enums\BatchStatus;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

//Exceptions
use CwConnector\Domain\Exceptions\Batch\BatchNotFoundException;
use CwConnector\Domain\Exceptions\Batch\UnfinishedBatchException;

//Ports
use CwConnector\Domain\Ports\IRepository;

//TestingTools
use CwConnector\Tests\Support\CwTestCase;
use Mockery;

class GetBatchResultUseCaseTest extends CwTestCase
{
    protected IRepository $repository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(IRepository::class);
    }

    public function test_ShouldBeInstantiateCorrectly(): void
    {
        $useCase = new GetBatchResultUseCase(
            repository: $this->repository
        );

        $this->assertInstanceOf(GetBatchResultUseCase::class, $useCase);
    }

    /**
     * @throws UnfinishedBatchException
     * @throws BatchNotFoundException
     */
    public function test_ShouldExecute(): void
    {
        $batch = $this->batch(withId: true, withResult: true);
        $batchId = $batch->batchId();
        $batch->setStatus(BatchStatus::FINISHED);

        $this->repository->shouldReceive('getById')
            ->with($batchId)->once()->andReturn($batch);

        $this->repository->shouldReceive('getBatchResult')
            ->with($batchId)->once()->andReturn($batch);

        $useCase = new GetBatchResultUseCase(
            repository: $this->repository
        );

        $batchResult = $useCase->execute(batchId: $batchId);

        $this->assertInstanceOf(BatchResult::class, $batchResult);
    }

    /**
     * @throws BatchNotFoundException
     */
    public function test_ShouldThrowExceptionWhenBatchInIncorrectStatus(): void
    {
        $this->expectException(UnfinishedBatchException::class);
        $this->expectExceptionMessage('Batch is not finished!');
        $this->expectExceptionCode(DomainErrorCodes::BATCH_UNFINISHED_BATCH);

        $batch = $this->batch(withId: true);
        $batchId = $batch->batchId();

        $this->repository->shouldReceive('getById')
            ->with($batchId)->once()->andReturn($batch);

        $this->repository->shouldReceive('getBatchResult')
            ->with($batchId)->once()->andReturn($batch);

        $useCase = new GetBatchResultUseCase(
            repository: $this->repository
        );

        $useCase->execute(batchId: $batchId);
    }

    /**
     * @throws BatchNotFoundException
     * @throws UnfinishedBatchException
     */
    public function test_ShouldThrowExceptionWhenBatchNotFound(): void
    {
        $this->expectException(BatchNotFoundException::class);
        $this->expectExceptionMessage('Batch not found!');
        $this->expectExceptionCode(DomainErrorCodes::BATCH_NOT_FOUND_EXCEPTION);

        $batchId = $this->batch(withId: true)->batchId();

        $this->repository->shouldReceive('getById')
            ->with($batchId)->once()->andReturn(null);

        $useCase = new GetBatchResultUseCase(
            repository: $this->repository
        );

        $useCase->execute(batchId: $batchId);
    }
}