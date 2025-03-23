<?php

declare(strict_types=1);

namespace Application\UseCases;

use Domain\Entities\Batch;
use Domain\Exceptions\Batch\BatchSendInBackgroundFailedException;
use Domain\Ports\IRepository;

class SendBatchInBackgroundUseCase
{
    public function __construct(
        private readonly IRepository $repository
    ){}

    /**
     * @throws BatchSendInBackgroundFailedException
     */
    public function execute(Batch $batch): string
    {
        $batch = $this->repository->sendBatchInBackground(batch: $batch);

        if (!$batch) {
            throw new BatchSendInBackgroundFailedException();
        }

        return $batch->batchId();
    }
}