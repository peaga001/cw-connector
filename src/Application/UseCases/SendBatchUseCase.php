<?php

declare(strict_types=1);

namespace Application\UseCases;

//ValueObjects
use Domain\ValueObjects\BatchResult;

//Entities
use Domain\Entities\Batch;

//Exceptions
use Domain\Exceptions\Batch\BatchSendFailedException;

//Ports
use Domain\Ports\IRepository;

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