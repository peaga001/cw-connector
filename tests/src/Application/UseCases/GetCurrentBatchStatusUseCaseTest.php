<?php

namespace Tests\src\Application\UseCases;

use Application\DTOs\BatchCurrentStatusDTO;
use Application\UseCases\GetCurrentBatchStatusUseCase;
use Domain\ErrorCodes\DomainErrorCodes;
use Domain\Exceptions\Batch\BatchNotFoundException;
use Domain\Ports\IRepository;
use Mockery;
use Tests\Support\CwTestCase;

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

        $dto = $useCase->execute(batchId: $batchId);

        $this->assertInstanceOf(BatchCurrentStatusDTO::class, $dto);
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