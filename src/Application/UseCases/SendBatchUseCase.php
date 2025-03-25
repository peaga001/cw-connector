<?php

declare(strict_types=1);

namespace CwConnector\Application\UseCases;

//ValueObjects
use CwConnector\Domain\ValueObjects\BatchResult;

//Entities
use CwConnector\Domain\Entities\Batch;

//Exceptions
use CwConnector\Domain\Exceptions\Batch\BatchSendFailedException;

//Ports
use CwConnector\Domain\Ports\IRepository;

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