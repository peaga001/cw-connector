<?php

declare(strict_types=1);

namespace CwConnector\Application\UseCases;

//ValueObjects
use CwConnector\Domain\ValueObjects\BatchResult;

//Enums
use CwConnector\Domain\Enums\BatchStatus;

//Exceptions
use CwConnector\Domain\Exceptions\Batch\UnfinishedBatchException;
use CwConnector\Domain\Exceptions\Batch\BatchNotFoundException;

//Ports
use CwConnector\Domain\Ports\IRepository;

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
