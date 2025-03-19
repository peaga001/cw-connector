<?php

declare(strict_types=1);

namespace Application\UseCases;

use App\Application\DTOs\BatchResultDTO;
use Domain\Entities\Batch;
use Domain\Enums\BatchStatus;
use Domain\Exceptions\Batch\BatchNotFoundException;
use Domain\Exceptions\Batch\UnfinishedBatchException;
use Domain\Ports\IRepository;

class GetBatchResultUseCase
{
    public function __construct(
        private readonly IRepository $repository
    ) {

    }

    /**
     * @throws BatchNotFoundException
     * @throws UnfinishedBatchException
     */
    public function execute(string $batchId): BatchResultDTO
    {
        $batch = $this->repository->getById($batchId);

        if(!$batch) {
            throw new BatchNotFoundException;
        }

        if(in_array($batch->status(), [BatchStatus::CREATED, BatchStatus::SENT])) {
            throw new UnfinishedBatchException;
        }

        $result = $this->repository->getBatchResult($batchId);

        return new BatchResultDTO(
            result: $result
        );
    }
}
