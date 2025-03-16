<?php

declare(strict_types=1);

namespace Application\UseCases;

use App\Application\DTOs\BatchResultDTO;
use Domain\Entities\Batch;
use Domain\Exceptions\Batch\BatchSendFailedException;
use Domain\Ports\IBatchRepository;

class SendBatchUseCase
{
    public function __construct(
        private readonly IBatchRepository $repository
    ){}

    public function execute(Batch $batch): BatchResultDTO
    {
        $errors = [];
        $result = $this->repository->sendBatch(batch: $batch);

        if (!$result) {
            $errors[] = new BatchSendFailedException;
        }

        return new BatchResultDTO(
            result: $result,
            errors: $errors
        );
    }
}