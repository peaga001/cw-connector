<?php

declare(strict_types=1);

namespace Application\UseCases;

use Domain\Enums\BatchStatus;
use Domain\Exceptions\Batch\BatchNotFoundException;
use Domain\Exceptions\Batch\UnfinishedBatchException;
use Domain\Ports\IRepository;
use Domain\ValueObjects\BatchResult\BatchResult;

class GetBatchResultUseCase
{
    public function __construct(
        private readonly IRepository $repository
    ) {}

    /**
     * @throws BatchNotFoundException
     * @throws UnfinishedBatchException
     */
    public function execute(string $batchId): BatchResult
    {
        $batch = $this->repository->getById($batchId);

        if(!$batch) {
            throw new BatchNotFoundException;
        }

        if(in_array($batch->status(), [BatchStatus::CREATED, BatchStatus::SENT])) {
            throw new UnfinishedBatchException;
        }

        return $this->repository->getBatchResult($batchId)->result();
    }
}
