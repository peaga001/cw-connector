<?php

declare(strict_types=1);

namespace CwConnector\Tests\src\Application\UseCases;

//UseCases
use CwConnector\Application\UseCases\GetCurrentBatchStatusUseCase;

//Enums
use CwConnector\Domain\Enums\BatchStatus;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

//Exceptions
use CwConnector\Domain\Exceptions\Batch\BatchNotFoundException;

//Ports
use CwConnector\Domain\Ports\IRepository;

//TestingTools
use CwConnector\Tests\Support\CwTestCase;
use Mockery;

class GetCurrentBatchStatusUseCaseTest extends CwTestCase
{
    protected IRepository $repository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(IRepository::class);
    }

    public function test_ShouldBeInstantiateCorrectly(): void
    {
        $useCase = new GetCurrentBatchStatusUseCase(
            repository: $this->repository
        );

        $this->assertInstanceOf(GetCurrentBatchStatusUseCase::class, $useCase);
    }

    /**
     * @throws BatchNotFoundException
     */
    public function test_ShouldExecute(): void
    {
        $batch = $this->batch(withId: true);
        $batchId = $batch->batchId();

        $this->repository->shouldReceive('getById')
            ->with($batchId)->once()->andReturn($batch);

        $useCase = new GetCurrentBatchStatusUseCase(
            repository: $this->repository
        );

        $status = $useCase->execute(batchId: $batchId);

        $this->assertIsInt($status);
        $this->assertContains(BatchStatus::tryFrom($status), BatchStatus::cases());
    }

    /**
     * @throws BatchNotFoundException
     */
    public function test_ShouldThrowExceptionWhenBatchNotFound(): void
    {
        $this->expectException(BatchNotFoundException::class);
        $this->expectExceptionMessage('Batch not found!');
        $this->expectExceptionCode(DomainErrorCodes::BATCH_NOT_FOUND_EXCEPTION);

        $batchId = $this->batch(withId: true)->batchId();

        $this->repository->shouldReceive('getById')
            ->with($batchId)->once()->andReturn(null);

        $useCase = new GetCurrentBatchStatusUseCase(
            repository: $this->repository
        );

        $useCase->execute(batchId: $batchId);
    }
}