<?php

declare(strict_types=1);

namespace Application\UseCases;

use App\Application\DTOs\BatchResultDTO;
use Domain\Exceptions\Batch\BatchNotFoundException;
use Domain\Ports\IBatchRepository;

class GetBatchResultUseCase
{
    public function __construct(
        private readonly IBatchRepository $repository
    ) {}

    public function execute(string $batchId): BatchResultDTO
    {
        $errors = [];
        $result = $this->repository->getBatchResult($batchId);

        if (!$result) {
            $errors[] = new BatchNotFoundException;
        }

        return new BatchResultDTO(
            result: $result,
            errors: $errors
        );
    }
}
