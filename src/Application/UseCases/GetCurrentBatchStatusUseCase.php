<?php

declare(strict_types=1);

namespace Application\UseCases;

use App\Application\DTOs\BatchCurrentStatusDTO;
use Domain\Exceptions\Batch\BatchNotFoundException;
use Domain\Ports\IRepository;

class GetCurrentBatchStatusUseCase
{
    public function __construct(
        private readonly IRepository $repository
    ){}

    public function execute(string $batchId): BatchCurrentStatusDTO
    {
        $errors = [];
        $batch = $this->repository->getById(id: $batchId);

        if (!$batch) {
            $errors[] = new BatchNotFoundException;
        }

        return new BatchCurrentStatusDTO(
            currentStatus: $batch->status()->value,
            errors: $errors
        );
    }
}