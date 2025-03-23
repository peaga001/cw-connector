<?php

namespace Tests\src\Application\UseCases;

use Application\UseCases\SendBatchInBackgroundUseCase;
use Domain\ErrorCodes\DomainErrorCodes;
use Domain\Exceptions\Batch\BatchSendInBackgroundFailedException;
use Domain\Ports\IRepository;
use Mockery;
use Tests\Support\CwTestCase;

class SendBatchInBackgroundUseCaseTest extends CwTestCase
{
    protected IRepository $repository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(IRepository::class);
    }

    public function test_ShouldBeInstantiateCorrectly(): void
    {
        $useCase = new SendBatchInBackgroundUseCase(
            repository: $this->repository
        );

        $this->assertInstanceOf(SendBatchInBackgroundUseCase::class, $useCase);
    }

    /**
     * @throws BatchSendInBackgroundFailedException
     */
    public function test_ShouldExecute(): void
    {
        $batch = $this->batch(withId: true);

        $this->repository->shouldReceive('sendBatchInBackground')
            ->with($batch)->once()->andReturn($batch);

        $useCase = new SendBatchInBackgroundUseCase(
            repository: $this->repository
        );

        $batchId = $useCase->execute(batch: $batch);

        $this->assertEquals($batch->batchId(), $batchId);
    }

    /**
     * @throws BatchSendInBackgroundFailedException
     */
    public function test_ShouldThrowExceptionWhenBatchNotFound(): void
    {
        $this->expectException(BatchSendInBackgroundFailedException::class);
        $this->expectExceptionMessage('Failed to send batch in background!');
        $this->expectExceptionCode(DomainErrorCodes::BATCH_SEND_IN_BACKGROUND_FAILED);

        $batch = $this->batch();

        $this->repository->shouldReceive('sendBatchInBackground')
            ->with($batch)->once()->andReturn(null);

        $useCase = new SendBatchInBackgroundUseCase(
            repository: $this->repository
        );

        $useCase->execute(batch: $batch);
    }
}