<?php

declare(strict_types=1);

namespace Application\UseCases;

use Domain\Entities\Batch;
use Domain\Exceptions\Batch\BatchSendFailedException;
use Domain\Ports\IRepository;
use Domain\ValueObjects\BatchResult\BatchResult;

class SendBatchUseCase
{
    public function __construct(
        private readonly IRepository $repository
    ){}

    /**
     * @throws BatchSendFailedException
     */
    public function execute(Batch $batch): BatchResult
    {
        $sentBatch = $this->repository->sendBatch(batch: $batch);

        if (!$sentBatch) {
            throw new BatchSendFailedException;
        }

        return $sentBatch->result();
    }
}