<?php

declare(strict_types=1);

namespace App\Infrastructure\API;

use App\Infrastructure\API\Config\IClientAPI;
use Domain\Entities\Batch;
use Domain\Ports\IBatchRepository;

class HTTPRepository implements IBatchRepository
{
    public function __construct(
        private readonly IClientAPI $clientAPI
    ){}

    public function getBatchResult(string $id): array
    {
        // TODO: Implement getBatchResult() method.
    }

    public function getById(string $id): ?Batch
    {

    }

    public function sendBatch(Batch $batch): array
    {
        // TODO: Implement sendBatch() method.
    }

    public function sendBatchInBackground(Batch $batch): Batch
    {
        // TODO: Implement sendBatchInBackground() method.
    }
}