<?php

declare(strict_types=1);

namespace Application\UseCases;

use Domain\Exceptions\Batch\BatchNotFoundException;
use Domain\Ports\IRepository;

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