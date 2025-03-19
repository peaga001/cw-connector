<?php

namespace Tests\src\Application\UseCases;

use App\Application\DTOs\BatchResultDTO;
use Application\UseCases\GetBatchResultUseCase;
use Domain\Enums\BatchStatus;
use Domain\ErrorCodes\DomainErrorCodes;
use Domain\Exceptions\Batch\BatchNotFoundException;
use Domain\Exceptions\Batch\UnfinishedBatchException;
use Domain\Ports\IRepository;
use Mockery;
use Tests\Support\CwTestCase;

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
        $batch = $this->batch(withId: true);
        $batchId = $batch->batchId();
        $batch->setStatus(BatchStatus::FINISHED);

        $this->repository->shouldReceive('getById')
            ->with($batchId)->once()->andReturn($batch);

        $this->repository->shouldReceive('getBatchResult')
            ->with($batchId)->once()->andReturn(['status' => 'success']);

        $useCase = new GetBatchResultUseCase(
            repository: $this->repository
        );

        $dto = $useCase->execute(batchId: $batchId);

        $this->assertInstanceOf(BatchResultDTO::class, $dto);
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
            ->with($batchId)->once()->andReturn(['status' => 'success']);

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