<?php

declare(strict_types=1);

namespace Application\UseCases;

use App\Application\DTOs\SendBatchInBackgroundDTO;
use Domain\Exceptions\Batch\BatchSendInBackgroundFailedException;
use Domain\Entities\Batch;
use Domain\Ports\IRepository;

class SendBatchInBackgroundUseCase
{
    public function __construct(
        private readonly IRepository $repository
    ){}

    public function execute(Batch $batch): SendBatchInBackgroundDTO
    {
        $errors = [];
        $batch = $this->repository->sendBatchInBackground(batch: $batch);

        if (!$batch) {
            $errors[] = new BatchSendInBackgroundFailedException();
        }

        return new SendBatchInBackgroundDTO(
            batchId: $batch->batchId(),
            errors: $errors
        );
    }
}