<?php

declare(strict_types=1);

namespace Application\UseCases;

use Application\DTOs\BatchResultDTO;
use Domain\Entities\Batch;
use Domain\Exceptions\Batch\BatchSendFailedException;
use Domain\Ports\IRepository;

class SendBatchUseCase
{
    public function __construct(
        private readonly IRepository $repository
    ){}

    /**
     * @throws BatchSendFailedException
     */
    public function execute(Batch $batch): BatchResultDTO
    {
        $result = $this->repository->sendBatch(batch: $batch);

        if (!$result) {
            throw new BatchSendFailedException;
        }

        return new BatchResultDTO(
            result: $result
        );
    }
}