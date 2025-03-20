<?php

declare(strict_types=1);

namespace Application\UseCases;

use Application\DTOs\SendBatchInBackgroundDTO;
use Domain\Exceptions\Batch\BatchSendInBackgroundFailedException;
use Domain\Entities\Batch;
use Domain\Ports\IRepository;

class SendBatchInBackgroundUseCase
{
    public function __construct(
        private readonly IRepository $repository
    ){}

    /**
     * @throws BatchSendInBackgroundFailedException
     */
    public function execute(Batch $batch): SendBatchInBackgroundDTO
    {
        $batch = $this->repository->sendBatchInBackground(batch: $batch);

        if (!$batch) {
            throw new BatchSendInBackgroundFailedException();
        }

        return new SendBatchInBackgroundDTO(
            batchId: $batch->batchId()
        );
    }
}