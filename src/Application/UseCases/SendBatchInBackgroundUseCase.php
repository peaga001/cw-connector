<?php

declare(strict_types=1);

namespace CwConnector\Application\UseCases;

//Entities
use CwConnector\Domain\Entities\Batch;

//Exceptions
use CwConnector\Domain\Exceptions\Batch\BatchSendInBackgroundFailedException;

//Ports
use CwConnector\Domain\Ports\IRepository;

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