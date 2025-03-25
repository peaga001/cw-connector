<?php

declare(strict_types=1);

namespace CwConnector\Application\UseCases;

//Exceptions
use CwConnector\Domain\Exceptions\Batch\BatchNotFoundException;

//Ports
use CwConnector\Domain\Ports\IRepository;

class GetCurrentBatchStatusUseCase
{
    public function __construct(
        private readonly IRepository $repository
    ){}

    /**
     * @throws BatchNotFoundException
     */
    public function execute(string $batchId): int
    {
        $batch = $this->repository->getById(id: $batchId);

        if (!$batch) {
            throw new BatchNotFoundException;
        }

        return $batch->status()->value;
    }
}