<?php

namespace Tests\src\Application\UseCases;

use Application\DTOs\BatchResultDTO;
use Application\UseCases\SendBatchUseCase;
use Domain\ErrorCodes\DomainErrorCodes;
use Domain\Exceptions\Batch\BatchSendFailedException;
use Domain\Ports\IRepository;
use Mockery;
use Tests\Support\CwTestCase;

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
        $batch = $this->batch();

        $this->repository->shouldReceive('sendBatch')
            ->with($batch)->once()->andReturn(['status' => 'success']);

        $useCase = new SendBatchUseCase(
            repository: $this->repository
        );

        $dto = $useCase->execute(batch: $batch);

        $this->assertInstanceOf(BatchResultDTO::class, $dto);
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