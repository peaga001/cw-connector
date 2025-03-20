<?php

declare(strict_types=1);

namespace Application\UseCases;

use Application\DTOs\BatchCurrentStatusDTO;
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
    public function execute(string $batchId): BatchCurrentStatusDTO
    {
        $batch = $this->repository->getById(id: $batchId);

        if (!$batch) {
            throw new BatchNotFoundException;
        }

        return new BatchCurrentStatusDTO(
            currentStatus: $batch->status()->value
        );
    }
}